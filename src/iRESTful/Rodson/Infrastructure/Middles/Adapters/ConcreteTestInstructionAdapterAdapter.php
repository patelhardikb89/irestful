<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteTestInstructionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers\Adapters\TestContainerInstructionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Adapters\Adapters\TestInstructionAdapterAdapter;

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
