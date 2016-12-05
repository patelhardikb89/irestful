<?php
namespace iRESTful\Rodson\ClassesControllers\Infrastructure\Factories;
use iRESTful\Rodson\ClassesControllers\Domain\Adapters\Adapters\Factories\ControllerAdapterAdapterFactory;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteClassControllerAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteCustomMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcretePropertyAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorParameterMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteConstructorAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Rodson\ClassesControllers\Infrastructure\Adapters\ConcreteControllerAdapterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\PHPCustomMethodSourceCodeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcretePrimitiveAdapter;

final class ConcreteControllerAdapterAdapterFactory implements ControllerAdapterAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $primitiveAdapter = new ConcretePrimitiveAdapter();

        //custom method adapter
        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $interfaceNamespaceAdapter = new ConcreteInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);
        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);
        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter();
        $classCustomMethodAdapter = new ConcreteCustomMethodAdapter($primitiveAdapter, $interfaceMethodParameterAdapter, $sourceCodeAdapter);

        //constructor:
        $classPropertyAdapter = new ConcretePropertyAdapter();
        $classConstructorParameterMethodAdapter = new ConcreteConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        //namespace
        $subClassNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($subClassNamespaceAdapter);

        return new ConcreteControllerAdapterAdapter(
            $classCustomMethodAdapter,
            $constructorAdapter,
            $classNamespaceAdapter
        );
    }

}
