<?php
namespace iRESTful\Classes\Infrastructure\Factories;
use iRESTful\Classes\Domain\Namespaces\Adapters\Factories\InterfaceNamespaceAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;

final class ConcreteInterfaceNamespaceAdapterFactory implements InterfaceNamespaceAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $namespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        return new ConcreteClassInterfaceNamespaceAdapter($namespaceAdapter);
    }

}
