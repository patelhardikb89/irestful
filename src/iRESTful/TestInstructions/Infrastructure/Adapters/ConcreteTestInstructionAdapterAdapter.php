<?php
namespace iRESTful\TestInstructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\TestInstructions\Infrastructure\Adapters\ConcreteTestInstructionAdapter;
use iRESTful\TestInstructions\Domain\Containers\Adapters\TestContainerInstructionAdapter;
use iRESTful\TestInstructions\Domain\Adapters\Adapters\TestInstructionAdapterAdapter;

final class ConcreteTestInstructionAdapterAdapter implements TestInstructionAdapterAdapter {
    private $instructionAdapterAdapter;
    private $testContainerInstructionAdapter;
    public function __construct(InstructionAdapterAdapter $instructionAdapterAdapter, TestContainerInstructionAdapter $testContainerInstructionAdapter) {
        $this->instructionAdapterAdapter = $instructionAdapterAdapter;
        $this->testContainerInstructionAdapter = $testContainerInstructionAdapter;
    }

    public function fromAnnotatedEntitiesToTestInstructionAdapter(array $annotatedEntities) {
        $instructionAdapter = $this->instructionAdapterAdapter->fromAnnotatedEntitiesToInstructionAdapter($annotatedEntities);
        return new ConcreteTestInstructionAdapter($instructionAdapter, $this->testContainerInstructionAdapter, $annotatedEntities);
    }

}
