<?php
namespace iRESTful\Rodson\Applications\Infrastructure\Applications;
use iRESTful\Rodson\Applications\Domain\Application;
use iRESTful\Rodson\Applications\Domain\Adapters\ApplicationAdapter;
use iRESTful\Rodson\Applications\Domain\Domains\Adapters\DomainAdapter;
use iRESTful\Rodson\DSLs\Domain\DSL;
use iRESTful\Rodson\ClassesControllers\Domain\Adapters\Adapters\Factories\ControllerAdapterAdapterFactory;
use iRESTful\Rodson\ClassesConfigurations\Domain\Adapters\Factories\ConfigurationAdapterFactory;
use iRESTful\Rodson\ClassesInstallations\Domain\Adapters\Factories\InstallationAdapterFactory;
use iRESTful\Rodson\ClassesTests\Domain\Adapters\Factories\TestAdapterFactory;
use iRESTful\Rodson\ClassesApplications\Domain\Adapters\Factories\ApplicationAdapterFactory;
use iRESTful\Rodson\ConfigurationsVagrants\Domain\Adapters\Factories\VagrantFileAdapterFactory;
use iRESTful\Rodson\ConfigurationsComposers\Domain\Adapters\Factories\ComposerAdapterFactory;
use iRESTful\Rodson\ConfigurationsPHPUnits\Domain\Adapters\Factories\PHPUnitAdapterFactory;
use iRESTful\Rodson\Outputs\Domain\Codes\Adapters\Factories\CodeAdapterFactory;
use iRESTful\Rodson\Outputs\Domain\Codes\Services\Factories\CodeServiceFactory;
use iRESTful\Rodson\Outputs\Domain\Codes\Factories\CodeFactory;

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
    private $codeFactory;
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
        CodeFactory $codeFactory,
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
        $this->codeFactory = $codeFactory;
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
                $this->dsl = $oneSubDSL->getDSL();
                $this->domainApplicationAdapter->fromDSLToApplication($this->dsl)->execute();
            }
        }

        $domain = $this->domainAdapter->fromProjectToDomain($project);
        $this->domainApplicationAdapter->fromDomainToApplication($domain)->execute();

        $name = $this->dsl->getName();
        $baseNamespace = $name->getNameInParts();

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
            'relational_database' => $project->getRelationalDatabase(),
            'entities' => $project->getEntities()
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
        $vagrantFile = $this->vagrantFileAdapterFactory->create()->fromDSLToVagrantFile($this->dsl);

        //we get the composer configurations:
        $composer = $this->composerAdapterFactory->create()->fromDataToComposer([
            'dsl' => $this->dsl,
            'installation' => $installationClass
        ]);

        //we get the phpunit configurations:
        $phpunit = $this->phpunitAdapterFactory->create()->fromDSLToPHPUnit($this->dsl);

        //we generate the code:
        $codeAdapter = $this->codeAdapterFactory->create();
        $phpunitCode = $codeAdapter->fromPHPUnitToCode($phpunit);
        $vagrantFileCodes = $codeAdapter->fromVagrantFileToCodes($vagrantFile);
        $composerCode = $codeAdapter->fromComposerToCode($composer);
        $controllerCodes = $codeAdapter->fromControllersToCodes($controllerClasses);
        $testCodes = $codeAdapter->fromTestsToCodes($tests);
        $installationCode = $codeAdapter->fromInstallationToCode($installationClass);
        $applicationCodes = $codeAdapter->fromApplicationToCodes($application);

        $gitIgnoreCode = $this->codeFactory->createGitIgnore();

        //we save the codes:
        $this->codeServiceFactory->create()->saveMultiple(array_merge(
            [$gitIgnoreCode],
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
