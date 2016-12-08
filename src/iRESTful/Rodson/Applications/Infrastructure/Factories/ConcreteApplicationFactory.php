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
use iRESTful\Rodson\Outputs\Infrastructure\Factories\ConcreteCodeFactoryFactory;
use iRESTful\Rodson\ClassesConverters\Infrastructure\Factories\ConcreteConverterAdapterFactory;
use iRESTful\Rodson\ConfigurationsDockerFiles\Infrastructure\Factories\ConcreteDockerFileAdapterFactory;

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
            'iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter' => 'iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteJsonControllerResponseAdapter',
            'iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Service' => 'iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Objects\ConcreteService'
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
        $dockerFileAdapterFactory = new ConcreteDockerFileAdapterFactory();
        $composerAdapterFactory = new ConcreteComposerAdapterFactory($this->codeDirectory);
        $phpunitAdapterFactory = new ConcretePHPUnitAdapterFactory();
        $codeAdapterFactory = new ConcreteCodeAdapterFactory(
            $this->templatePath,
            $this->outputFolderPath,
            $this->codeDirectory,
            $this->webDirectory
        );

        $codeFactoryFactory = new ConcreteCodeFactoryFactory(
            $this->templatePath,
            $this->outputFolderPath
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
            $dockerFileAdapterFactory,
            $composerAdapterFactory,
            $phpunitAdapterFactory,
            $codeAdapterFactory,
            $codeFactoryFactory->create(),
            $fileCodeServiceFactory,
            $domainAdapterFactory->create(),
            $domainApplicationAdapter,
            $dsl
        );
    }

}
