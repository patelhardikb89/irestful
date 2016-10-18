<?php
namespace iRESTful\TestInstructions\Domain\CustomMethods\Adapters;
use iRESTful\TestInstructions\Domain\TestInstruction;

interface CustomMethodAdapter {
    public function fromTestInstructionToCustomMethods(TestInstruction $testInstruction);
}
