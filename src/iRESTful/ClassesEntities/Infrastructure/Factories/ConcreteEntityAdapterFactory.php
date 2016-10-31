<?php
namespace iRESTful\ClassesEntities\Infrastructure\Factories;
use iRESTful\ClassesEntities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\ClassesEntities\Infrastructure\Adapters\ConcreteEntityAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcretePropertyAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteCustomMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorParameterMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorAdapter;
use iRESTful\Classes\Infrastructure\Adapters\PHPCustomMethodSourceCodeAdapter;

final class ConcreteEntityAdapterFactory implements EntityAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $interfaceNamespaceAdapter = new ConcreteInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);
        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $classPropertyAdapter = new ConcretePropertyAdapter();
        $subClassNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($subClassNamespaceAdapter);
        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter('input', true);
        $classCustomMethodAdapter = new ConcreteCustomMethodAdapter($interfaceMethodParameterAdapter, $sourceCodeAdapter);

        $interfaceMethodAdapter = new ConcreteInterfaceMethodAdapter($classCustomMethodAdapter, $interfaceMethodParameterAdapter);
        $interfaceAdapter = new ConcreteInterfaceAdapter($interfaceNamespaceAdapter, $interfaceMethodAdapter);

        $classConstructorParameterMethodAdapter = new ConcreteConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        return new ConcreteEntityAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $classCustomMethodAdapter);
    }

}
