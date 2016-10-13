<?php
namespace iRESTful\TestInstructions\Infrastructure\Objects;
use iRESTful\TestInstructions\Domain\TestInstruction;
use iRESTful\TestInstructions\Domain\Exceptions\TestInstructionException;

final class ConcreteTestInstruction implements TestInstruction {
    private $instructions;
    private $containerInstructions;
    private $input;
    public function __construct(array $instructions = null, array $containerInstructions = null, array $input = null) {

        if (empty($input)) {
            $input = null;
        }

        if (empty($instructions)) {
            $instructions = null;
        }

        if (empty($containerInstructions)) {
            $containerInstructions = null;
        }

        $amount = (empty($instructions) ? 0 : 1) + (empty($containerInstructions) ? 0 : 1);
        if ($amount == 0) {
            throw new TestInstructionException('There must be instructions and/or containerInstructions.  '.$amount.' given.');
        }

        $this->instructions = $instructions;
        $this->containerInstructions = $containerInstructions;
        $this->input = $input;
    }

    public function hasInstructions() {
        return !empty($this->instructions);
    }

    public function getInstructions() {
        return $this->instructions;
    }

    public function hasContainerInstructions() {
        return !empty($this->containerInstructions);
    }

    public function getContainerInstructions() {
        return $this->containerInstructions;
    }

    public function hasInput() {
        return !empty($this->input);
    }

    public function getInput() {
        return $this->input;
    }

}
