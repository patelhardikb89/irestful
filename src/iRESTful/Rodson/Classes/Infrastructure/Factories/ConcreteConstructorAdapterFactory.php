<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Factories;
use iRESTful\Rodson\Classes\Domain\Constructors\Adapters\Factories\ConstructorAdapterFactory;
use iRESTful\Rodson\Classes\Infrastructure\Factories\ConcreteCustomMethodAdapterFactory;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorParameterMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcretePropertyAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Factories\ConcreteInterfaceNamespaceAdapterFactory;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;

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
