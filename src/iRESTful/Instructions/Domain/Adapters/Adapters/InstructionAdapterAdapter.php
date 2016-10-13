<?php
namespace iRESTful\Instructions\Domain\Adapters\Adapters;

interface InstructionAdapterAdapter {
    public function fromAnnotatedEntitiesToInstructionAdapter(array $annotatedEntities);
}
