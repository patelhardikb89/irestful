<?php
namespace iRESTful\Rodson\TestInstructions\Domain\CustomMethods\Nodes\Adapters;
use iRESTful\Rodson\TestInstructions\Domain\TestInstruction;

interface CustomMethodNodeAdapter {
    public function fromTestInstructionsToCustomMethodNodes(array $testInstructions);
    public function fromTestInstructionToCustomMethodNode(TestInstruction $testInstruction);
}
