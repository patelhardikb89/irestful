<?php
namespace iRESTful\TestInstructions\Infrastructure\Factories;
use iRESTful\TestInstructions\Domain\Adapters\Adapters\Factories\TestInstructionAdapterAdapterFactory;
use iRESTful\Instructions\Infrastructure\Factories\ConcreteInstructionAdapterAdapterFactory;
use iRESTful\TestInstructions\Infrastructure\Adapters\ConcreteTestInstructionComparisonAdapter;
use iRESTful\TestInstructions\Infrastructure\Adapters\ConcreteTestSampleInstructionAdapter;
use iRESTful\TestInstructions\Infrastructure\Adapters\ConcreteTestContainerInstructionAdapter;
use iRESTful\TestInstructions\Infrastructure\Adapters\ConcreteTestInstructionAdapterAdapter;

final class ConcreteTestInstructionAdapterAdapterFactory implements TestInstructionAdapterAdapterFactory {

    public function __construct() {

    }

    public function create() {

        $instructionAdapterAdapterFactory = new ConcreteInstructionAdapterAdapterFactory();
        $instructionAdapterAdapter = $instructionAdapterAdapterFactory->create();

        $instructionComparisonAdapter = new ConcreteTestInstructionComparisonAdapter();
        $classTestContainerSampleInstructorAdapter = new ConcreteTestSampleInstructionAdapter($instructionAdapterAdapter, $instructionComparisonAdapter);
        $classTestContainerInstructionAdapter = new ConcreteTestContainerInstructionAdapter($instructionAdapterAdapter, $classTestContainerSampleInstructorAdapter, $instructionComparisonAdapter);
        return new ConcreteTestInstructionAdapterAdapter($instructionAdapterAdapter, $classTestContainerInstructionAdapter);
    }

}
