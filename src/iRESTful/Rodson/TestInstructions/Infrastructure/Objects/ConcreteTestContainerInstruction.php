<?php
namespace iRESTful\Rodson\TestInstructions\Infrastructure\Objects;
use iRESTful\Rodson\TestInstructions\Domain\Containers\TestContainerInstruction;
use iRESTful\Rodson\TestInstructions\Domain\Containers\Exceptions\TestContainerInstructionException;
use iRESTful\Rodson\TestInstructions\Domain\Comparisons\TestInstructionComparison;

final class ConcreteTestContainerInstruction implements TestContainerInstruction {
    private $instructions;
    private $sampleInstructions;
    private $comparison;
    public function __construct(array $instructions = null, array $sampleInstructions = null, TestInstructionComparison $comparison = null) {

        if (empty($instructions)) {
            $instructions = null;
        }

        if (empty($sampleInstructions)) {
            $sampleInstructions = null;
        }

        $amount = (empty($instructions) ? 0 : 1) + (empty($sampleInstructions) ? 0 : 1) + (empty($comparison) ? 0 : 1);
        if ($amount == 0) {
            throw new TestContainerInstructionException('There must be instructions, sampleInstructions and/or comparison.  '.$amount.' given.');
        }

        $this->instructions = $instructions;
        $this->sampleInstructions = $sampleInstructions;
        $this->comparison = $comparison;
    }

    public function hasInstructions() {
        return !empty($this->instructions);
    }

    public function getInstructions() {
        return $this->instructions;
    }

    public function hasSampleInstructions() {
        return !empty($this->sampleInstructions);
    }

    public function getSampleInstructions() {
        return $this->sampleInstructions;
    }

    public function hasComparison() {
        return !empty($this->comparison);
    }

    public function getComparison() {
        return $this->comparison;
    }

}
