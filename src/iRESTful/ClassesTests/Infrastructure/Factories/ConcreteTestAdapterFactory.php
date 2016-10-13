<?php
namespace iRESTful\ClassesTests\Infrastructure\Factories;
use iRESTful\ClassesTests\Domain\Adapters\Factories\TestAdapterFactory;
use iRESTful\ClassesTests\Infrastructure\Adapters\ConcreteTestAdapter;
use iRESTful\ClassesTests\Infrastructure\Adapters\ConcreteTestTransformAdapter;
use iRESTful\ClassesTests\Infrastructure\Adapters\ConcreteTestControllerAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodParameterTypeAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassMethodCustomAdapter;
use iRESTful\TestInstructions\Infrastructure\Factories\ConcreteTestInstructionAdapterAdapterFactory;

final class ConcreteTestAdapterFactory implements TestAdapterFactory {
    private $baseNamespaces;
    public function __construct(array $baseNamespaces) {
        $this->baseNamespaces = $baseNamespaces;
    }

    public function create() {

        $testTransformAdapter = new ConcreteTestTransformAdapter($this->baseNamespaces);

        $testInstructionAdapterAdapterFactory = new ConcreteTestInstructionAdapterAdapterFactory();
        $testInstructionAdapterAdapter = $testInstructionAdapterAdapterFactory->create();

        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespaces);
        $interfaceNamespaceAdapter = new ConcreteClassInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);

        $interfaceMethodParamaterTypeAdapter = new ConcreteClassInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteClassInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);
        $customMethodAdapter = new ConcreteClassMethodCustomAdapter($interfaceMethodParameterAdapter);

        $testControllerAdapter = new ConcreteTestControllerAdapter($testInstructionAdapterAdapter, $customMethodAdapter, $this->baseNamespaces);

        return new ConcreteTestAdapter($testTransformAdapter, $testControllerAdapter);
    }

}
