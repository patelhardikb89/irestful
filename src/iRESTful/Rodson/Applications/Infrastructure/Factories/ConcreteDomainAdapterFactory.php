<?php
namespace iRESTful\Rodson\Applications\Infrastructure\Factories;
use iRESTful\Rodson\Applications\Domain\Domains\Adapters\Factories\DomainAdapterFactory;
use iRESTful\Rodson\ClassesObjectsAnnotations\Infrastructure\Factories\ConcreteAnnotatedObjectAdapterFactory;
use iRESTful\Rodson\ClassesEntitiesAnnotations\Infrastructure\Factories\ConcreteAnnotatedEntityAdapterFactory;
use iRESTful\Rodson\ClassesValues\Infrastructure\Factories\ConcreteValueAdapterFactory;
use iRESTful\Rodson\Outputs\Infrastructure\Factories\ConcreteCodeAdapterFactory;
use iRESTful\Rodson\Applications\Infrastructure\Adapters\ConcreteDomainAdapter;
use iRESTful\Rodson\DSLs\Domain\DSL;

final class ConcreteDomainAdapterFactory implements DomainAdapterFactory {
    private $dsl;
    private $timezone;
    private $templatePath;
    private $outputFolderPath;
    private $codeDirectory;
    private $webDirectory;
    public function __construct(DSL $dsl, string $timezone, string $templatePath, string $outputFolderPath, string $codeDirectory, string $webDirectory) {
        $this->dsl = $dsl;
        $this->timezone = $timezone;
        $this->templatePath = $templatePath;
        $this->outputFolderPath = $outputFolderPath;
        $this->codeDirectory = $codeDirectory;
        $this->webDirectory = $webDirectory;
    }

    public function create() {
        $name = $this->dsl->getName();
        $project = $this->dsl->getProject();
        $baseNamespace = [$name->getOrganizationName(), $name->getProjectName()];

        $annotatedObjectAdapterFactory = new ConcreteAnnotatedObjectAdapterFactory($baseNamespace);
        $annotatedEntityAdapterFactory = new ConcreteAnnotatedEntityAdapterFactory($baseNamespace, $this->timezone);
        $valueAdapterFactory = new ConcreteValueAdapterFactory($baseNamespace);
        $codeAdapterFactory = new ConcreteCodeAdapterFactory($this->templatePath, $this->outputFolderPath, $this->codeDirectory, $this->webDirectory);
        return new ConcreteDomainAdapter($annotatedObjectAdapterFactory, $annotatedEntityAdapterFactory, $valueAdapterFactory);
    }

}
