<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters\Adapters;

interface InstructionAdapterAdapter {
    public function fromAnnotatedClassesToInstructionAdapter(array $annotatedClasses);
}
