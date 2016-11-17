<?php
namespace iRESTful\Applications\Infrastructure\Factories;
use iRESTful\Applications\Domain\Factories\ApplicationFactory;
use iRESTful\Applications\Infrastructure\Factories\ConcreteDomainAdapterFactory;
use iRESTful\Applications\Infrastructure\Factories\ConcreteDomainApplicationFactory;
use iRESTful\Applications\Infrastructure\Applications\ConcreteApplication;
use iRESTful\DSLs\Infrastructure\Factories\ConcreteDSLAdapterFactory;
use iRESTful\DSLs\Infrastructure\Repositories\JsonFileDSLRepository;
use iRESTful\ClassesControllers\Infrastructure\Factories\ConcreteControllerAdapterAdapterFactory;
use iRESTful\ClassesConfigurations\Infrastructure\Factories\ConcreteConfigurationAdapterFactory;
use iRESTful\ClassesInstallations\Infrastructure\Factories\ConcreteInstallationAdapterFactory;
use iRESTful\ClassesTests\Infrastructure\Factories\ConcreteTestAdapterFactory;
use iRESTful\ClassesApplications\Infrastructure\Factories\ConcreteApplicationAdapterFactory;
use iRESTful\ConfigurationsVagrants\Infrastructure\Factories\ConcreteVagrantFileAdapterFactory;
use iRESTful\ConfigurationsComposers\Infrastructure\Factories\ConcreteComposerAdapterFactory;
use iRESTful\ConfigurationsPHPUnits\Infrastructure\Factories\ConcretePHPUnitAdapterFactory;
use iRESTful\Outputs\Infrastructure\Factories\ConcreteCodeAdapterFactory;
use iRESTful\Outputs\Infrastructure\Factories\FileCodeServiceFactory;
use iRESTful\Applications\Infrastructure\Adapters\ConcreteDomainApplicationAdapter;

final class ConcreteApplicationFactory implements ApplicationFactory {
    private $timezone;
    private $templatePath;
    private $jsonFilePath;
    private $outputFolderPath;
    private $delimiter;
    private $codeDirectory;
    private $webDirectory;
    private $dependenciesInterfaceClassMapper;
    public function __construct(string $timezone, string $templatePath, string $jsonFilePath, string $outputFolderPath) {
        $this->timezone = $timezone;
        $this->templatePath = $templatePath;
        $this->jsonFilePath = $jsonFilePath;
        $this->outputFolderPath = $outputFolderPath;

        $this->delimiter = '___';
        $this->codeDirectory = 'src';
        $this->webDirectory = 'web';
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

    public function create() {

        $dslAdapterFactory = new ConcreteDSLAdapterFactory();
        $repository = new JsonFileDSLRepository($dslAdapterFactory);
        $dsl = $repository->retrieve($this->jsonFilePath);

        $name = $dsl->getName();
        $project = $dsl->getProject();
        $baseNamespace = [$name->getOrganizationName(), $name->getProjectName()];

        $controllerAdapterAdapterFactory = new ConcreteControllerAdapterAdapterFactory($baseNamespace);
        $configurationAdapterFactory = new ConcreteConfigurationAdapterFactory(
            $baseNamespace,
            $this->dependenciesInterfaceClassMapper,
            $this->delimiter,
            $this->timezone
        );

        $installationAdapterFactory = new ConcreteInstallationAdapterFactory($baseNamespace);
        $testAdapterFactory = new ConcreteTestAdapterFactory($baseNamespace);
        $applicationAdapterFactory = new ConcreteApplicationAdapterFactory($baseNamespace);
        $vagrantFileAdapterFactory = new ConcreteVagrantFileAdapterFactory();
        $composerAdapterFactory = new ConcreteComposerAdapterFactory($this->codeDirectory);
        $phpunitAdapterFactory = new ConcretePHPUnitAdapterFactory();
        $codeAdapterFactory = new ConcreteCodeAdapterFactory(
            $this->templatePath,
            $this->outputFolderPath,
            $this->codeDirectory,
            $this->webDirectory
        );

        $fileCodeServiceFactory = new FileCodeServiceFactory();

        $domainAdapterFactory = new ConcreteDomainAdapterFactory(
            $dsl,
            $this->timezone,
            $this->templatePath,
            $this->outputFolderPath,
            $this->codeDirectory,
            $this->webDirectory
        );

        $domainApplicationAdapter = new ConcreteDomainApplicationAdapter(
            $this->timezone,
            $this->templatePath,
            $this->outputFolderPath,
            $this->codeDirectory,
            $this->webDirectory
        );

        return new ConcreteApplication(
            $controllerAdapterAdapterFactory,
            $configurationAdapterFactory,
            $installationAdapterFactory,
            $testAdapterFactory,
            $applicationAdapterFactory,
            $vagrantFileAdapterFactory,
            $composerAdapterFactory,
            $phpunitAdapterFactory,
            $codeAdapterFactory,
            $fileCodeServiceFactory,
            $domainAdapterFactory->create(),
            $domainApplicationAdapter,
            $dsl
        );
    }

}