<?php
namespace iRESTful\Rodson\ClassesApplications\Infrastructure\Factories;
use iRESTful\Rodson\ClassesApplications\Domain\Adapters\Factories\ApplicationAdapterFactory;
use iRESTful\Rodson\ClassesApplications\Infrastructure\Adapters\ConcreteApplicationAdapter;
use iRESTful\Rodson\ClassesApplications\Infrastructure\Factories\ConcreteApplicationNamespaceFactory;

final class ConcreteApplicationAdapterFactory implements ApplicationAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $namespaceFactory = new ConcreteApplicationNamespaceFactory($this->baseNamespace);
        return new ConcreteApplicationAdapter($namespaceFactory);
    }

}
