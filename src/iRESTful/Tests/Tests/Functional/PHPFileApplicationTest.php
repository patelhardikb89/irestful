<?php
namespace iRESTful\Tests\Tests\Functional;
use iRESTful\DSLs\Infrastructure\Factories\ConcreteDSLAdapterFactory;
use iRESTful\Classes\Infrastructure\Factories\ConcreteSpecificClassAdapterFactory;
use iRESTful\Annotations\Infrastructure\Factories\ConcreteAnnotationAdapterFactory;
use iRESTful\ClassesObjectsAnnotations\Infrastructure\Factories\ConcreteAnnotatedObjectAdapterFactory;
use iRESTful\ClassesEntitiesAnnotations\Infrastructure\Factories\ConcreteAnnotatedEntityAdapterFactory;
use iRESTful\ClassesControllers\Infrastructure\Factories\ConcreteControllerAdapterAdapterFactory;
use iRESTful\TestInstructions\Infrastructure\Factories\ConcreteTestInstructionAdapterAdapterFactory;
use iRESTful\ClassesValues\Infrastructure\Factories\ConcreteValueAdapterFactory;
use iRESTful\ClassesConfigurations\Infrastructure\Factories\ConcreteConfigurationAdapterFactory;
use iRESTful\ClassesTests\Infrastructure\Factories\ConcreteTestAdapterFactory;
use iRESTful\ClassesInstallations\Infrastructure\Factories\ConcreteInstallationAdapterFactory;
use iRESTful\ClassesApplications\Infrastructure\Factories\ConcreteApplicationAdapterFactory;
use iRESTful\ConfigurationsVagrants\Infrastructure\Factories\ConcreteVagrantFileAdapterFactory;
use iRESTful\ConfigurationsComposers\Infrastructure\Factories\ConcreteComposerAdapterFactory;
use iRESTful\ConfigurationsPHPUnits\Infrastructure\Factories\ConcretePHPUnitAdapterFactory;
use iRESTful\Outputs\Infrastructure\Factories\ConcreteCodeAdapterFactory;
use iRESTful\Outputs\Infrastructure\Factories\FileCodeServiceFactory;

final class PHPFileApplicationTest extends \PHPUnit_Framework_TestCase {
    private $data;
    private $outputFolderPath;
    private $codeDirectory;
    private $webDirectory;
    private $templatePath;
    private $delimiter;
    private $timezone;
    private $dependenciesInterfaceClassMapper;
    public function setUp() {

        $filePath = realpath(__DIR__.'/../../Files/Authenticated/authenticated.json');

        $baseDirectory = explode('/', $filePath);
        array_pop($baseDirectory);

        $this->data = json_decode(file_get_contents($filePath), true);
        $this->data['base_directory'] = implode('/', $baseDirectory);

        $this->outputFolderPath = realpath(__DIR__.'/../../Files/Authenticated/Output');
        $this->codeDirectory = 'src';
        $this->webDirectory = 'web';
        $this->templatePath = '/vagrant/templates/code/php';

        $this->delimiter = '___';
        $this->timezone = 'America/Montreal';

        $this->dependenciesInterfaceClassMapper = [
            'iRESTful\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory' => 'iRESTful\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRepositoryFactory',
            'iRESTful\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory' => 'iRESTful\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityAdapterFactory',
            'iRESTful\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory' => 'iRESTful\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityPartialSetRepositoryFactory',
            'iRESTful\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory' => 'iRESTful\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetRepositoryFactory',
            'iRESTful\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory' => 'iRESTful\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRelationRepositoryFactory',
            'iRESTful\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory' => 'iRESTful\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityServiceWithSubEntitiesFactory',
            'iRESTful\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory' => 'iRESTful\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetServiceWithSubEntitiesFactory',
            'iRESTful\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter' => 'iRESTful\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter'
        ];

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $dslAdapterFactory = new ConcreteDSLAdapterFactory();
        $dslAdapter = $dslAdapterFactory->create();
        $dsl = $dslAdapter->fromDataToDSL($this->data);

        $name = $dsl->getName();
        $baseNamespace = [
            $name->getOrganizationName(),
            $name->getProjectName()
        ];

        //we get the annotated class objects:
        $project = $dsl->getProject();
        $objects = $project->getObjects();
        $annotatedObjectAdapterFactory = new ConcreteAnnotatedObjectAdapterFactory($baseNamespace);
        $annotatedObjects = $annotatedObjectAdapterFactory->create()->fromDSLObjectsToAnnotatedClassObjects($objects);

        //we get class entities:
        $annotatedEntityAdapterFactory = new ConcreteAnnotatedEntityAdapterFactory($baseNamespace);
        $annotatedEntities = $annotatedEntityAdapterFactory->create()->fromDSLObjectsToAnnotatedEntities($objects);

        //we get controller classes:
        $controllers = $project->getControllers();
        $controllerAdapterAdapterFactory = new ConcreteControllerAdapterAdapterFactory($baseNamespace);
        $controllerClasses = $controllerAdapterAdapterFactory->create()->fromAnnotatedEntitiesToControllerAdapter($annotatedEntities)->fromDSLControllersToControllers($controllers);

        //we get the value classes:
        $types = $project->getTypes();
        $valueAdapterFactory = new ConcreteValueAdapterFactory($baseNamespace);
        $valueClasses = $valueAdapterFactory->create()->fromTypesToValues($types);

        //we get the configuration class:
        $configurationAdapterFactory = new ConcreteConfigurationAdapterFactory($baseNamespace, $this->dependenciesInterfaceClassMapper, $this->delimiter, $this->timezone);
        $configuration = $configurationAdapterFactory->create()->fromDataToConfiguration([
            'annotated_entities' => $annotatedEntities,
            'annotated_objects' => $annotatedObjects,
            'values' => $valueClasses,
            'controllers' => [
                'inputs' => $controllers,
                'classes' => $controllerClasses
            ]
        ]);

        //we get the test classes:
        $testAdapterFactory = new ConcreteTestAdapterFactory($baseNamespace);
        $tests = $testAdapterFactory->create()->fromDataToTests([
            'annotated_entities' => $annotatedEntities,
            'configuration' => $configuration,
            'controllers' => $controllers
        ]);

        //we get the installation class:
        $installationAdapterFactory = new ConcreteInstallationAdapterFactory($baseNamespace);
        $installationClass = $installationAdapterFactory->create()->fromDataToInstallation([
            'object_configuration' => $configuration->getObjectConfiguration(),
            'relational_database' => $project->getRelationalDatabase()
        ]);

        //we get the application class:
        $applicationAdapterFactory = new ConcreteApplicationAdapterFactory($baseNamespace);
        $application = $applicationAdapterFactory->create()->fromConfigurationToApplication($configuration);

        //we get the vagrant configurations:
        $vagrantFileAdapterFactory = new ConcreteVagrantFileAdapterFactory();
        $vagrantFile = $vagrantFileAdapterFactory->create()->fromDSLToVagrantFile($dsl);

        //we get the composer configurations:
        $composerAdapterFactory = new ConcreteComposerAdapterFactory($this->codeDirectory);
        $composer = $composerAdapterFactory->create()->fromDataToComposer([
            'dsl' => $dsl,
            'installation' => $installationClass
        ]);

        //we get the phpunit configurations:
        $phpunitAdapterFactory = new ConcretePHPUnitAdapterFactory();
        $phpunit = $phpunitAdapterFactory->create()->fromDSLToPHPUnit($dsl);

        //we generate the code:
        $codeAdapterFactory = new ConcreteCodeAdapterFactory($this->templatePath, $this->outputFolderPath, $this->codeDirectory, $this->webDirectory);
        $codeAdapter = $codeAdapterFactory->create();

        $phpunitCode = $codeAdapter->fromPHPUnitToCode($phpunit);
        $vagrantFileCodes = $codeAdapter->fromVagrantFileToCodes($vagrantFile);
        $composerCode = $codeAdapter->fromComposerToCode($composer);
        $annotatedObjectCodes = $codeAdapter->fromAnnotatedObjectsToCodes($annotatedObjects);
        $annotatedEntityCodes = $codeAdapter->fromAnnotatedEntitiesToCodes($annotatedEntities);
        $valueCodes = $codeAdapter->fromValuesToCodes($valueClasses);
        $controllerCodes = $codeAdapter->fromControllersToCodes($controllerClasses);
        $testCodes = $codeAdapter->fromTestsToCodes($tests);
        $installationCode = $codeAdapter->fromInstallationToCode($installationClass);
        $applicationCodes = $codeAdapter->fromApplicationToCodes($application);

        //we save the codes on disk:
        $fileCodeServiceFactory = new FileCodeServiceFactory();
        $fileCodeServiceFactory->create()->saveMultiple(array_merge(
            [$phpunitCode],
            $vagrantFileCodes,
            [$composerCode],
            $annotatedObjectCodes,
            $annotatedEntityCodes,
            $valueCodes,
            $controllerCodes,
            $testCodes,
            [$installationCode],
            $applicationCodes
        ));

        $this->assertTrue(true);

    }

}
