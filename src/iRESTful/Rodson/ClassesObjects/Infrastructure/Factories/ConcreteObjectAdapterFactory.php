<?php
namespace iRESTful\Rodson\ClassesObjects\Infrastructure\Factories;
use iRESTful\Rodson\ClassesObjects\Domain\Adapters\Factories\ObjectAdapterFactory;
use iRESTful\Rodson\ClassesObjects\Infrastructure\Adapters\ConcreteObjectAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcretePropertyAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteCustomMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorParameterMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\PHPCustomMethodSourceCodeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcretePrimitiveAdapter;
use iRESTful\Rodson\ClassesConverters\Infrastructure\Factories\ConcreteConverterAdapterFactory;

final class ConcreteObjectAdapterFactory implements ObjectAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $primitiveAdapter = new ConcretePrimitiveAdapter();

        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $interfaceNamespaceAdapter = new ConcreteInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);
        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $classPropertyAdapter = new ConcretePropertyAdapter();
        $subClassNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($subClassNamespaceAdapter);
        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter('input', true);
        $classCustomMethodAdapter = new ConcreteCustomMethodAdapter($primitiveAdapter, $interfaceMethodParameterAdapter, $sourceCodeAdapter);

        $interfaceMethodAdapter = new ConcreteInterfaceMethodAdapter($classCustomMethodAdapter, $interfaceMethodParameterAdapter);
        $interfaceAdapter = new ConcreteInterfaceAdapter($interfaceNamespaceAdapter, $interfaceMethodAdapter);

        $classConstructorParameterMethodAdapter = new ConcreteConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        $converterAdapterFactory = new ConcreteConverterAdapterFactory($this->baseNamespace);
        $converterAdapter = $converterAdapterFactory->create();

        return new ConcreteObjectAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $classCustomMethodAdapter, $converterAdapter);
    }

}
