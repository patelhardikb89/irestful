<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Comparisons;

interface TestInstructionComparison {
    public function getInstruction();
    public function hasSample();
    public function getSample();
    public function hasSamples();
    public function getSamples();
    public function hasSecondInstruction();
    public function getSecondInstruction();
}
