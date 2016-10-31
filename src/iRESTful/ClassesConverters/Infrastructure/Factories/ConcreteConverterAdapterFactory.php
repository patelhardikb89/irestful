<?php
namespace iRESTful\ClassesConverters\Infrastructure\Factories;
use iRESTful\ClassesConverters\Domain\Adapters\Factories\ConverterAdapterFactory;
use iRESTful\ClassesConverters\Infrastructure\Adapters\ConcreteConverterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcretePropertyAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteCustomMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorParameterMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorAdapter;
use iRESTful\ClassesConverters\Infrastructure\Adapters\ConcreteConverterMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\PHPCustomMethodSourceCodeAdapter;

final class ConcreteConverterAdapterFactory implements ConverterAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $interfaceNamespaceAdapter = new ConcreteInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);

        $subClassNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($subClassNamespaceAdapter);

        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $classPropertyAdapter = new ConcretePropertyAdapter();
        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter('input', true);
        $classCustomMethodAdapter = new ConcreteCustomMethodAdapter($interfaceMethodParameterAdapter, $sourceCodeAdapter);

        $interfaceMethodAdapter = new ConcreteInterfaceMethodAdapter($classCustomMethodAdapter, $interfaceMethodParameterAdapter);
        $interfaceAdapter = new ConcreteInterfaceAdapter($interfaceNamespaceAdapter, $interfaceMethodAdapter);

        $classConstructorParameterMethodAdapter = new ConcreteConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        $converterMethodAdapter = new ConcreteConverterMethodAdapter($interfaceMethodParameterAdapter);

        return new ConcreteConverterAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $converterMethodAdapter);
    }

}
