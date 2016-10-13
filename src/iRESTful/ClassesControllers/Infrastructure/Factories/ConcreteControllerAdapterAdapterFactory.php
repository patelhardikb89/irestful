<?php
namespace iRESTful\ClassesControllers\Infrastructure\Factories;
use iRESTful\ClassesControllers\Domain\Adapters\Adapters\Factories\ControllerAdapterAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassControllerAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodParameterTypeAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassMethodCustomAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassPropertyAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassConstructorParameterMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassConstructorParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassConstructorAdapter;
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
        $interfaceNamespaceAdapter = new ConcreteClassInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);
        $interfaceMethodParamaterTypeAdapter = new ConcreteClassInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteClassInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);
        $classCustomMethodAdapter = new ConcreteClassMethodCustomAdapter($interfaceMethodParameterAdapter);

        //constructor:
        $classPropertyAdapter = new ConcreteClassPropertyAdapter();
        $classConstructorParameterMethodAdapter = new ConcreteClassConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteClassConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteClassConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

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
