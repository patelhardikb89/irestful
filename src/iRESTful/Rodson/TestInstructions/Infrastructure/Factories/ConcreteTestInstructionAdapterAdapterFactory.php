<?php
namespace iRESTful\Rodson\TestInstructions\Infrastructure\Factories;
use iRESTful\Rodson\TestInstructions\Domain\Adapters\Adapters\Factories\TestInstructionAdapterAdapterFactory;
use iRESTful\Rodson\Instructions\Infrastructure\Factories\ConcreteInstructionAdapterAdapterFactory;
use iRESTful\Rodson\TestInstructions\Infrastructure\Adapters\ConcreteTestInstructionComparisonAdapter;
use iRESTful\Rodson\TestInstructions\Infrastructure\Adapters\ConcreteTestSampleInstructionAdapter;
use iRESTful\Rodson\TestInstructions\Infrastructure\Adapters\ConcreteTestContainerInstructionAdapter;
use iRESTful\Rodson\TestInstructions\Infrastructure\Adapters\ConcreteTestInstructionAdapterAdapter;

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
