<?php
namespace iRESTful\ClassesValues\Infrastructure\Factories;
use iRESTful\ClassesValues\Domain\Adapters\Factories\ValueAdapterFactory;
use iRESTful\ClassesValues\Infrastructure\Adapters\ConcreteValueAdapter;
use iRESTful\Classes\Infrastructure\Factories\ConcreteClassNamespaceAdapterFactory;
use iRESTful\Classes\Infrastructure\Factories\ConcreteInterfaceAdapterFactory;
use iRESTful\Classes\Infrastructure\Factories\ConcreteConstructorAdapterFactory;
use iRESTful\Classes\Infrastructure\Factories\ConcreteCustomMethodAdapterFactory;
use iRESTful\ClassesConverters\Infrastructure\Factories\ConcreteConverterAdapterFactory;

final class ConcreteValueAdapterFactory implements ValueAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $classNamespaceAdapterFactory = new ConcreteClassNamespaceAdapterFactory($this->baseNamespace);
        $classNamespaceAdapter = $classNamespaceAdapterFactory->create();

        $interfaceAdapterFactory = new ConcreteInterfaceAdapterFactory($this->baseNamespace);
        $interfaceAdapter = $interfaceAdapterFactory->create();

        $constructorAdapterFactory = new ConcreteConstructorAdapterFactory($this->baseNamespace);
        $constructorAdapter = $constructorAdapterFactory->create();

        $customMethodAdapterFactory = new ConcreteCustomMethodAdapterFactory($this->baseNamespace);
        $customMethodAdapter = $customMethodAdapterFactory->create();

        $converterAdapterFactory = new ConcreteConverterAdapterFactory($this->baseNamespace);
        $converterAdapter = $converterAdapterFactory->create();

        return new ConcreteValueAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $customMethodAdapter, $converterAdapter);
    }

}
