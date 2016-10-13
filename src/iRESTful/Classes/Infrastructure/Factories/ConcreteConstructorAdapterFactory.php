<?php
namespace iRESTful\Classes\Infrastructure\Factories;
use iRESTful\Classes\Domain\Constructors\Adapters\Factories\ConstructorAdapterFactory;
use iRESTful\Classes\Infrastructure\Factories\ConcreteCustomMethodAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassConstructorAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassConstructorParameterMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassConstructorParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassPropertyAdapter;
use iRESTful\Classes\Infrastructure\Factories\ConcreteInterfaceNamespaceAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodParameterTypeAdapter;

final class ConcreteConstructorAdapterFactory implements ConstructorAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $classCustomMethodAdapterFactory = new ConcreteCustomMethodAdapterFactory($this->baseNamespace);
        $classCustomMethodAdapter = $classCustomMethodAdapterFactory->create();

        $interfaceNamespaceAdapterFactory = new ConcreteInterfaceNamespaceAdapterFactory($this->baseNamespace);
        $interfaceNamespaceAdapter = $interfaceNamespaceAdapterFactory->create();

        $interfaceMethodParameterTypeAdapter = new ConcreteClassInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteClassInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParameterTypeAdapter);

        //constructor:
        $classPropertyAdapter = new ConcreteClassPropertyAdapter();
        $classConstructorParameterMethodAdapter = new ConcreteClassConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteClassConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        return new ConcreteClassConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);
    }

}
