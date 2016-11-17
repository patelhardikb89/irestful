<?php
namespace iRESTful\Rodson\ClassesTests\Infrastructure\Factories;
use iRESTful\Rodson\ClassesTests\Domain\Adapters\Factories\TestAdapterFactory;
use iRESTful\Rodson\ClassesTests\Infrastructure\Adapters\ConcreteTestAdapter;
use iRESTful\Rodson\ClassesTests\Infrastructure\Adapters\ConcreteTestTransformAdapter;
use iRESTful\Rodson\ClassesTests\Infrastructure\Adapters\ConcreteTestControllerAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Rodson\TestInstructions\Infrastructure\Adapters\PHPCustomMethodAdapter;
use iRESTful\Rodson\TestInstructions\Infrastructure\Factories\ConcreteTestInstructionAdapterAdapterFactory;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteCustomMethodAdapter;
use iRESTful\Rodson\TestInstructions\Infrastructure\Adapters\ConcreteCustomMethodNodeAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\PHPCustomMethodSourceCodeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcretePrimitiveAdapter;
use iRESTful\Rodson\ClassesTests\Infrastructure\Adapters\ConcreteTestCRUDAdapter;

final class ConcreteTestAdapterFactory implements TestAdapterFactory {
    private $baseNamespaces;
    public function __construct(array $baseNamespaces) {
        $this->baseNamespaces = $baseNamespaces;
    }

    public function create() {

        $primitiveAdapter = new ConcretePrimitiveAdapter();

        $testTransformAdapter = new ConcreteTestTransformAdapter($this->baseNamespaces);

        $testInstructionAdapterAdapterFactory = new ConcreteTestInstructionAdapterAdapterFactory();
        $testInstructionAdapterAdapter = $testInstructionAdapterAdapterFactory->create();

        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespaces);
        $interfaceNamespaceAdapter = new ConcreteInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);

        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);
        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter('this->data', false);
        $customMethodAdapter = new ConcreteCustomMethodAdapter($primitiveAdapter, $interfaceMethodParameterAdapter, $sourceCodeAdapter);
        $testCustomMethodAdapter = new PHPCustomMethodAdapter($customMethodAdapter, $sourceCodeAdapter);
        $testCustomMethodNodeAdapter = new ConcreteCustomMethodNodeAdapter($testCustomMethodAdapter);

        $testCRUDAdapter = new ConcreteTestCRUDAdapter($this->baseNamespaces);

        $testControllerAdapter = new ConcreteTestControllerAdapter($testInstructionAdapterAdapter, $testCustomMethodNodeAdapter, $this->baseNamespaces);

        return new ConcreteTestAdapter($testTransformAdapter, $testCRUDAdapter, $testControllerAdapter);
    }

}
