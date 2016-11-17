<?php
namespace iRESTful\Applications\Infrastructure\Factories;
use iRESTful\Applications\Domain\Domains\Adapters\Factories\DomainAdapterFactory;
use iRESTful\ClassesObjectsAnnotations\Infrastructure\Factories\ConcreteAnnotatedObjectAdapterFactory;
use iRESTful\ClassesEntitiesAnnotations\Infrastructure\Factories\ConcreteAnnotatedEntityAdapterFactory;
use iRESTful\ClassesValues\Infrastructure\Factories\ConcreteValueAdapterFactory;
use iRESTful\Outputs\Infrastructure\Factories\ConcreteCodeAdapterFactory;
use iRESTful\Applications\Infrastructure\Adapters\ConcreteDomainAdapter;
use iRESTful\DSLs\Domain\DSL;

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
