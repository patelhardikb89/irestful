<?php
namespace iRESTful\TestInstructions\Infrastructure\Objects;
use iRESTful\TestInstructions\Domain\Comparisons\TestInstructionComparison;
use iRESTful\Instructions\Domain\Instruction;
use iRESTful\Classes\Domain\Samples\Sample;
use iRESTful\TestInstructions\Domain\Comparisons\Exceptions\TestInstructionComparisonException;

final class ConcreteTestInstructionComparison implements TestInstructionComparison {
    private $instruction;
    private $sample;
    private $samples;
    private $secondInstruction;
    public function __construct(Instruction $instruction, Sample $sample = null, array $samples = null, Instruction $secondInstruction = null) {

        $amount = (empty($sample) ? 0 : 1) + (empty($samples) ? 0 : 1) + (empty($secondInstruction) ? 0 : 1);
        if ($amount != 1) {
            throw new TestInstructionComparisonException('There must be a Sample, samples or a second Instruction object. '.$amount.' given.');
        }

        $this->instruction = $instruction;
        $this->sample = $sample;
        $this->samples = $samples;
        $this->secondInstruction = $secondInstruction;
    }

    public function getInstruction() {
        return $this->instruction;
    }

    public function hasSample() {
        return !empty($this->sample);
    }

    public function getSample() {
        return $this->sample;
    }

    public function hasSamples() {
        return !empty($this->samples);
    }

    public function getSamples() {
        return $this->samples;
    }

    public function hasSecondInstruction() {
        return !empty($this->secondInstruction);
    }

    public function getSecondInstruction() {
        return $this->secondInstruction;
    }

}
