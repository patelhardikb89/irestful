<?php
namespace iRESTful\Rodson\TestInstructions\Infrastructure\Adapters;
use iRESTful\Rodson\TestInstructions\Domain\TestInstruction;
use iRESTful\Rodson\TestInstructions\Domain\CustomMethods\Nodes\Adapters\CustomMethodNodeAdapter;
use iRESTful\Rodson\TestInstructions\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\TestInstructions\Infrastructure\Objects\ConcreteCustomMethodNode;

final class ConcreteCustomMethodNodeAdapter implements CustomMethodNodeAdapter {
    private $customMethodAdapter;
    public function __construct(CustomMethodAdapter $customMethodAdapter) {
        $this->customMethodAdapter = $customMethodAdapter;
    }

    public function fromTestInstructionsToCustomMethodNodes(array $testInstructions) {
        $output = [];
        foreach($testInstructions as $oneTestInstruction) {
            $output[] = $this->fromTestInstructionToCustomMethodNode($oneTestInstruction);
        }

        return $output;
    }
    
    public function fromTestInstructionToCustomMethodNode(TestInstruction $testInstruction) {
        $initCustomMethod = $this->customMethodAdapter->fromTestInstructionToTestInitCustomMethod($testInstruction);
        $containerTestCustomMethods = $this->customMethodAdapter->fromTestInstructionToCustomMethods($testInstruction);
        return new ConcreteCustomMethodNode($containerTestCustomMethods, [$initCustomMethod]);
    }

}
