<?php
namespace iRESTful\TestInstructions\Domain\CustomMethods\Nodes\Adapters;
use iRESTful\TestInstructions\Domain\TestInstruction;

interface CustomMethodNodeAdapter {
    public function fromTestInstructionsToCustomMethodNodes(array $testInstructions);
    public function fromTestInstructionToCustomMethodNode(TestInstruction $testInstruction);
}
