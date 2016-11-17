<?php
namespace iRESTful\Rodson\TestInstructions\Domain\Adapters\Adapters;

interface TestInstructionAdapterAdapter {
    public function fromAnnotatedEntitiesToTestInstructionAdapter(array $annotatedEntities);
}
