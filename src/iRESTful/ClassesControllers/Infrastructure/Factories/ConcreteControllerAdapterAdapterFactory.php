<?php
namespace iRESTful\ClassesControllers\Infrastructure\Factories;
use iRESTful\ClassesControllers\Domain\Adapters\Adapters\Factories\ControllerAdapterAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassControllerAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteMethodCustomAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcretePropertyAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorParameterMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteConstructorAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Instructions\Infrastructure\Factories\ConcreteInstructionAdapterAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\ClassesControllers\Infrastructure\Adapters\ConcreteControllerAdapterAdapter;

final class ConcreteControllerAdapterAdapterFactory implements ControllerAdapterAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        //class instruction:
        $instructionAdapterAdapterFactory = new ConcreteInstructionAdapterAdapterFactory();
        $instructionAdapterAdapter = $instructionAdapterAdapterFactory->create();

        //custom method adapter
        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $interfaceNamespaceAdapter = new ConcreteInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);
        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);
        $classCustomMethodAdapter = new ConcreteMethodCustomAdapter($interfaceMethodParameterAdapter);

        //constructor:
        $classPropertyAdapter = new ConcretePropertyAdapter();
        $classConstructorParameterMethodAdapter = new ConcreteConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        //namespace
        $subClassNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($subClassNamespaceAdapter);

        return new ConcreteControllerAdapterAdapter(
            $instructionAdapterAdapter,
            $classCustomMethodAdapter,
            $constructorAdapter,
            $classNamespaceAdapter
        );
    }

}
