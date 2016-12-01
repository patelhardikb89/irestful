<?php
namespace iRESTful\Rodson\TestInstructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Rodson\TestInstructions\Infrastructure\Adapters\ConcreteTestInstructionAdapter;
use iRESTful\Rodson\TestInstructions\Domain\Containers\Adapters\TestContainerInstructionAdapter;
use iRESTful\Rodson\TestInstructions\Domain\Adapters\Adapters\TestInstructionAdapterAdapter;

final class ConcreteTestInstructionAdapterAdapter implements TestInstructionAdapterAdapter {
    private $instructionAdapterAdapter;
    private $testContainerInstructionAdapter;
    public function __construct(InstructionAdapterAdapter $instructionAdapterAdapter, TestContainerInstructionAdapter $testContainerInstructionAdapter) {
        $this->instructionAdapterAdapter = $instructionAdapterAdapter;
        $this->testContainerInstructionAdapter = $testContainerInstructionAdapter;
    }

    public function fromAnnotatedEntitiesToTestInstructionAdapter(array $annotatedEntities) {
        $instructionAdapter = $this->instructionAdapterAdapter->fromDataToInstructionAdapter([
            'annotated_entities' => $annotatedEntities
        ]);
        return new ConcreteTestInstructionAdapter($instructionAdapter, $this->testContainerInstructionAdapter, $annotatedEntities);
    }

}
