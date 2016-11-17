<?php
namespace iRESTful\Applications\Infrastructure\Adapters;
use iRESTful\Applications\Domain\Adapters\ApplicationAdapter;
use iRESTful\Applications\Infrastructure\Factories\ConcreteDomainAdapterFactory;
use iRESTful\Applications\Infrastructure\Applications\ConcreteDomainApplication;
use iRESTful\Outputs\Infrastructure\Factories\ConcreteCodeAdapterFactory;
use iRESTful\Outputs\Infrastructure\Factories\FileCodeServiceFactory;
use iRESTful\Applications\Domain\Domains\Domain;
use iRESTful\DSLs\Domain\DSL;

final class ConcreteDomainApplicationAdapter implements ApplicationAdapter {
    private $timezone;
    private $templatePath;
    private $outputFolderPath;
    public function __construct(string $timezone, string $templatePath, string $outputFolderPath, string $codeDirectory, string $webDirectory) {
        $this->timezone = $timezone;
        $this->templatePath = $templatePath;
        $this->outputFolderPath = $outputFolderPath;
        $this->codeDirectory = $codeDirectory;
        $this->webDirectory = $webDirectory;
    }

    public function fromDSLToApplication(DSL $dsl) {

        $domainAdapterFactory = new ConcreteDomainAdapterFactory(
            $dsl,
            $this->timezone,
            $this->templatePath,
            $this->outputFolderPath,
            $this->codeDirectory,
            $this->webDirectory
        );

        $project = $dsl->getProject();
        $domain = $domainAdapterFactory->create()->fromProjectToDomain($project);
        return $this->fromDomainToApplication($domain);
    }

    public function fromDomainToApplication(Domain $domain) {
        $fileCodeServiceFactory = new FileCodeServiceFactory();
        $codeAdapterFactory = new ConcreteCodeAdapterFactory($this->templatePath, $this->outputFolderPath, $this->codeDirectory, $this->webDirectory);
        return new ConcreteDomainApplication($fileCodeServiceFactory, $codeAdapterFactory, $domain);
    }

}
