<?php
namespace iRESTful\Rodson\ClassesEntities\Infrastructure\Factories;
use iRESTful\Rodson\ClassesEntities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\Rodson\ClassesEntities\Infrastructure\Adapters\ConcreteEntityAdapter;
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

final class ConcreteEntityAdapterFactory implements EntityAdapterFactory {
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
        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter();
        $classCustomMethodAdapter = new ConcreteCustomMethodAdapter($primitiveAdapter, $interfaceMethodParameterAdapter, $sourceCodeAdapter);

        $interfaceMethodAdapter = new ConcreteInterfaceMethodAdapter($classCustomMethodAdapter, $interfaceMethodParameterAdapter);
        $interfaceAdapter = new ConcreteInterfaceAdapter($interfaceNamespaceAdapter, $interfaceMethodAdapter);

        $classConstructorParameterMethodAdapter = new ConcreteConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        return new ConcreteEntityAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $classCustomMethodAdapter);
    }

}
