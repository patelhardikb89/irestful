<?php
namespace iRESTful\Rodson\Instructions\Domain\Adapters\Adapters;

interface InstructionAdapterAdapter {
    public function fromAnnotatedEntitiesToInstructionAdapter(array $annotatedEntities);
}
