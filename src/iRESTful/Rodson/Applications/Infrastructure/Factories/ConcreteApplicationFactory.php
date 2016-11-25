<?php
namespace iRESTful\Rodson\Applications\Infrastructure\Factories;
use iRESTful\Rodson\Applications\Domain\Factories\ApplicationFactory;
use iRESTful\Rodson\Applications\Infrastructure\Factories\ConcreteDomainAdapterFactory;
use iRESTful\Rodson\Applications\Infrastructure\Factories\ConcreteDomainApplicationFactory;
use iRESTful\Rodson\Applications\Infrastructure\Applications\ConcreteApplication;
use iRESTful\Rodson\DSLs\Infrastructure\Factories\ConcreteDSLAdapterFactory;
use iRESTful\Rodson\DSLs\Infrastructure\Repositories\JsonFileDSLRepository;
use iRESTful\Rodson\ClassesControllers\Infrastructure\Factories\ConcreteControllerAdapterAdapterFactory;
use iRESTful\Rodson\ClassesConfigurations\Infrastructure\Factories\ConcreteConfigurationAdapterFactory;
use iRESTful\Rodson\ClassesInstallations\Infrastructure\Factories\ConcreteInstallationAdapterFactory;
use iRESTful\Rodson\ClassesTests\Infrastructure\Factories\ConcreteTestAdapterFactory;
use iRESTful\Rodson\ClassesApplications\Infrastructure\Factories\ConcreteApplicationAdapterFactory;
use iRESTful\Rodson\ConfigurationsVagrants\Infrastructure\Factories\ConcreteVagrantFileAdapterFactory;
use iRESTful\Rodson\ConfigurationsComposers\Infrastructure\Factories\ConcreteComposerAdapterFactory;
use iRESTful\Rodson\ConfigurationsPHPUnits\Infrastructure\Factories\ConcretePHPUnitAdapterFactory;
use iRESTful\Rodson\Outputs\Infrastructure\Factories\ConcreteCodeAdapterFactory;
use iRESTful\Rodson\Outputs\Infrastructure\Factories\FileCodeServiceFactory;
use iRESTful\Rodson\Applications\Infrastructure\Adapters\ConcreteDomainApplicationAdapter;

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
            'iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory' => 'iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRepositoryFactory',
            'iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory' => 'iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityAdapterFactory',
            'iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory' => 'iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityPartialSetRepositoryFactory',
            'iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory' => 'iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetRepositoryFactory',
            'iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory' => 'iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityRelationRepositoryFactory',
            'iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory' => 'iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityServiceWithSubEntitiesFactory',
            'iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory' => 'iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntitySetServiceWithSubEntitiesFactory',
            'iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter' => 'iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter'
        ];
    }

    public function create() {

        $dslAdapterFactory = new ConcreteDSLAdapterFactory();
        $repository = new JsonFileDSLRepository($dslAdapterFactory);
        $dsl = $repository->retrieve($this->jsonFilePath);

        $name = $dsl->getName();
        $project = $dsl->getProject();
        $baseNamespace = $name->getNameInParts();

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
