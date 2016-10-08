<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Adapters\Adapters\ControllerAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassControllerAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceNamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceMethodParameterTypeAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceMethodParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassMethodCustomAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassPropertyAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorParameterMethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteClassInstructionAdapterAdapterFactory;

final class ConcreteSpecificClassControllerAdapterAdapter implements ControllerAdapterAdapter {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function fromAnnotatedEntitiesToControllerAdapter(array $annotatedEntities) {

        //class instruction:
        $classInstructionAdapterAdapterFactory = new ConcreteClassInstructionAdapterAdapterFactory();
        $classInstructionAdapterAdapter = $classInstructionAdapterAdapterFactory->create();

        //custom method adapter
        $interfaceNamespaceAdapter = new ConcreteClassInterfaceNamespaceAdapter($this->baseNamespace);
        $interfaceMethodParamaterTypeAdapter = new ConcreteClassInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteClassInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);
        $classCustomMethodAdapter = new ConcreteClassMethodCustomAdapter($interfaceMethodParameterAdapter);

        //constructor:
        $classPropertyAdapter = new ConcreteClassPropertyAdapter();
        $classConstructorParameterMethodAdapter = new ConcreteClassConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteClassConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteClassConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        //namespace
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($this->baseNamespace);

        return new ConcreteSpecificClassControllerAdapter(
            $classInstructionAdapterAdapter,
            $classCustomMethodAdapter,
            $constructorAdapter,
            $classNamespaceAdapter,
            $annotatedEntities
        );
    }

}
