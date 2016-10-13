<?php
namespace iRESTful\ClassesConverters\Infrastructure\Factories;
use iRESTful\ClassesConverters\Domain\Adapters\Factories\ConverterAdapterFactory;
use iRESTful\ClassesConverters\Infrastructure\Adapters\ConcreteConverterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodParameterTypeAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassPropertyAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassMethodCustomAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassConstructorParameterMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassConstructorParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassConstructorAdapter;
use iRESTful\ClassesConverters\Infrastructure\Adapters\ConcreteConverterMethodAdapter;

final class ConcreteConverterAdapterFactory implements ConverterAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $interfaceNamespaceAdapter = new ConcreteClassInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);

        $subClassNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($subClassNamespaceAdapter);

        $interfaceMethodParamaterTypeAdapter = new ConcreteClassInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteClassInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $classPropertyAdapter = new ConcreteClassPropertyAdapter();
        $classCustomMethodAdapter = new ConcreteClassMethodCustomAdapter($interfaceMethodParameterAdapter);

        $interfaceMethodAdapter = new ConcreteClassInterfaceMethodAdapter($classCustomMethodAdapter, $interfaceMethodParameterAdapter);
        $interfaceAdapter = new ConcreteClassInterfaceAdapter($interfaceNamespaceAdapter, $interfaceMethodAdapter);

        $classConstructorParameterMethodAdapter = new ConcreteClassConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteClassConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteClassConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        $converterMethodAdapter = new ConcreteConverterMethodAdapter($interfaceMethodParameterAdapter);

        return new ConcreteConverterAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $converterMethodAdapter);
    }

}
