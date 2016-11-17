<?php
namespace iRESTful\Applications\Infrastructure\Applications;
use iRESTful\Applications\Domain\Application;
use iRESTful\Applications\Domain\Adapters\ApplicationAdapter;
use iRESTful\Applications\Domain\Domains\Adapters\DomainAdapter;
use iRESTful\DSLs\Domain\DSL;
use iRESTful\ClassesControllers\Domain\Adapters\Adapters\Factories\ControllerAdapterAdapterFactory;
use iRESTful\ClassesConfigurations\Domain\Adapters\Factories\ConfigurationAdapterFactory;
use iRESTful\ClassesInstallations\Domain\Adapters\Factories\InstallationAdapterFactory;
use iRESTful\ClassesTests\Domain\Adapters\Factories\TestAdapterFactory;
use iRESTful\ClassesApplications\Domain\Adapters\Factories\ApplicationAdapterFactory;
use iRESTful\ConfigurationsVagrants\Domain\Adapters\Factories\VagrantFileAdapterFactory;
use iRESTful\ConfigurationsComposers\Domain\Adapters\Factories\ComposerAdapterFactory;
use iRESTful\ConfigurationsPHPUnits\Domain\Adapters\Factories\PHPUnitAdapterFactory;
use iRESTful\Outputs\Domain\Codes\Adapters\Factories\CodeAdapterFactory;
use iRESTful\Outputs\Domain\Codes\Services\Factories\CodeServiceFactory;

final class ConcreteApplication implements Application {
    private $controllerAdapterAdapterFactory;
    private $configurationAdapterFactory;
    private $installationAdapterFactory;
    private $testAdapterFactory;
    private $applicationAdapterFactory;
    private $vagrantFileAdapterFactory;
    private $composerAdapterFactory;
    private $phpunitAdapterFactory;
    private $codeAdapterFactory;
    private $codeServiceFactory;
    private $domainAdapter;
    private $domainApplicationAdapter;
    private $dsl;
    public function __construct(
        ControllerAdapterAdapterFactory $controllerAdapterAdapterFactory,
        ConfigurationAdapterFactory $configurationAdapterFactory,
        InstallationAdapterFactory $installationAdapterFactory,
        TestAdapterFactory $testAdapterFactory,
        ApplicationAdapterFactory $applicationAdapterFactory,
        VagrantFileAdapterFactory $vagrantFileAdapterFactory,
        ComposerAdapterFactory $composerAdapterFactory,
        PHPUnitAdapterFactory $phpunitAdapterFactory,
        CodeAdapterFactory $codeAdapterFactory,
        CodeServiceFactory $codeServiceFactory,
        DomainAdapter $domainAdapter,
        ApplicationAdapter $domainApplicationAdapter,
        DSL $dsl
    ) {
        $this->controllerAdapterAdapterFactory = $controllerAdapterAdapterFactory;
        $this->configurationAdapterFactory = $configurationAdapterFactory;
        $this->installationAdapterFactory = $installationAdapterFactory;
        $this->testAdapterFactory = $testAdapterFactory;
        $this->applicationAdapterFactory = $applicationAdapterFactory;
        $this->vagrantFileAdapterFactory = $vagrantFileAdapterFactory;
        $this->composerAdapterFactory = $composerAdapterFactory;
        $this->phpunitAdapterFactory = $phpunitAdapterFactory;
        $this->codeAdapterFactory = $codeAdapterFactory;
        $this->codeServiceFactory = $codeServiceFactory;
        $this->domainAdapter = $domainAdapter;
        $this->domainApplicationAdapter = $domainApplicationAdapter;
        $this->dsl = $dsl;
    }

    public function execute() {

        $project = $this->dsl->getProject();
        if ($project->hasParents()) {
            $parents = $project->getParents();
            foreach($parents as $oneSubDSL) {
                $dsl = $oneSubDSL->getDSL();
                $this->domainApplicationAdapter->fromDSLToApplication($dsl)->execute();
            }
        }

        $domain = $this->domainAdapter->fromProjectToDomain($project);
        $this->domainApplicationAdapter->fromDomainToApplication($domain)->execute();

        $name = $dsl->getName();
        $baseNamespace = [
            $name->getOrganizationName(),
            $name->getProjectName()
        ];

        $annotatedEntities = $domain->getEntities();
        $annotatedObjects = $domain->getObjects();
        $valueClasses = $domain->getValues();

        //we get controller classes:
        $controllers = [];
        $controllerClasses = [];
        if ($project->hasControllers()) {
            $controllers = $project->getControllers();
            $controllerClasses = $this->controllerAdapterAdapterFactory->create()->fromAnnotatedEntitiesToControllerAdapter($annotatedEntities)->fromDSLControllersToControllers($controllers);
        }

        //we get the configuration class:
        $configuration = $this->configurationAdapterFactory->create()->fromDataToConfiguration([
            'annotated_entities' => $annotatedEntities,
            'annotated_objects' => $annotatedObjects,
            'values' => $valueClasses,
            'controllers' => [
                'inputs' => $controllers,
                'classes' => $controllerClasses
            ]
        ]);

        //we get the installation class:
        $installationClass = $this->installationAdapterFactory->create()->fromDataToInstallation([
            'object_configuration' => $configuration->getObjectConfiguration(),
            'relational_database' => $project->getRelationalDatabase()
        ]);


        //we get the test classes:
        $tests = $this->testAdapterFactory->create()->fromDataToTests([
            'annotated_entities' => $annotatedEntities,
            'configuration' => $configuration,
            'controllers' => $controllers,
            'installation' => $installationClass
        ]);

        //we get the application class:
        $application = $this->applicationAdapterFactory->create()->fromConfigurationToApplication($configuration);

        //we get the vagrant configurations:
        $vagrantFile = $this->vagrantFileAdapterFactory->create()->fromDSLToVagrantFile($dsl);

        //we get the composer configurations:
        $composer = $this->composerAdapterFactory->create()->fromDataToComposer([
            'dsl' => $dsl,
            'installation' => $installationClass
        ]);

        //we get the phpunit configurations:
        $phpunit = $this->phpunitAdapterFactory->create()->fromDSLToPHPUnit($dsl);

        //we generate the code:
        $codeAdapter = $this->codeAdapterFactory->create();

        $phpunitCode = $codeAdapter->fromPHPUnitToCode($phpunit);
        $vagrantFileCodes = $codeAdapter->fromVagrantFileToCodes($vagrantFile);
        $composerCode = $codeAdapter->fromComposerToCode($composer);
        $controllerCodes = $codeAdapter->fromControllersToCodes($controllerClasses);
        $testCodes = $codeAdapter->fromTestsToCodes($tests);
        $installationCode = $codeAdapter->fromInstallationToCode($installationClass);
        $applicationCodes = $codeAdapter->fromApplicationToCodes($application);

        //we save the codes:
        $this->codeServiceFactory->create()->saveMultiple(array_merge(
            [$phpunitCode],
            $vagrantFileCodes,
            [$composerCode],
            $controllerCodes,
            $testCodes,
            [$installationCode],
            $applicationCodes
        ));
    }

}
