<?php
namespace iRESTful\Rodson\TestInstructions\Domain\CustomMethods\Adapters;
use iRESTful\Rodson\TestInstructions\Domain\TestInstruction;

interface CustomMethodAdapter {
    public function fromTestInstructionToCustomMethods(TestInstruction $testInstruction);
}
