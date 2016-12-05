<?php
namespace iRESTful\Rodson\ClassesConverters\Infrastructure\Factories;
use iRESTful\Rodson\ClassesConverters\Domain\Adapters\Factories\ConverterAdapterFactory;
use iRESTful\Rodson\ClassesConverters\Infrastructure\Adapters\ConcreteConverterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcretePropertyAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteCustomMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorParameterMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorAdapter;
use iRESTful\Rodson\ClassesConverters\Infrastructure\Adapters\ConcreteConverterMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\PHPCustomMethodSourceCodeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcretePrimitiveAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Factories\ConcreteCustomMethodAdapterFactory;

final class ConcreteConverterAdapterFactory implements ConverterAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $primitiveAdapter = new ConcretePrimitiveAdapter();

        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $interfaceNamespaceAdapter = new ConcreteInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);

        $subClassNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($subClassNamespaceAdapter);

        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $classPropertyAdapter = new ConcretePropertyAdapter();
        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter();
        $classCustomMethodAdapter = new ConcreteCustomMethodAdapter($primitiveAdapter, $interfaceMethodParameterAdapter, $sourceCodeAdapter);

        $interfaceMethodAdapter = new ConcreteInterfaceMethodAdapter($classCustomMethodAdapter, $interfaceMethodParameterAdapter);
        $interfaceAdapter = new ConcreteInterfaceAdapter($interfaceNamespaceAdapter, $interfaceMethodAdapter);

        $classConstructorParameterMethodAdapter = new ConcreteConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        $converterMethodAdapter = new ConcreteConverterMethodAdapter($interfaceMethodParameterAdapter);
        $customMethodAdapterFactory = new ConcreteCustomMethodAdapterFactory($this->baseNamespace);

        return new ConcreteConverterAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $converterMethodAdapter, $customMethodAdapterFactory->create());
    }

}
