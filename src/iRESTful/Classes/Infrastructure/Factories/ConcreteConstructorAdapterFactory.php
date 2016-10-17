<?php
namespace iRESTful\Classes\Infrastructure\Factories;
use iRESTful\Classes\Domain\Constructors\Adapters\Factories\ConstructorAdapterFactory;
use iRESTful\Classes\Infrastructure\Factories\ConcreteCustomMethodAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorParameterMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcretePropertyAdapter;
use iRESTful\Classes\Infrastructure\Factories\ConcreteInterfaceNamespaceAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;

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

        $interfaceMethodParameterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParameterTypeAdapter);

        //constructor:
        $classPropertyAdapter = new ConcretePropertyAdapter();
        $classConstructorParameterMethodAdapter = new ConcreteConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        return new ConcreteConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);
    }

}
