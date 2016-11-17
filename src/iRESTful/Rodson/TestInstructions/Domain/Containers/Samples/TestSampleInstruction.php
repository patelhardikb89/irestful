<?php
namespace iRESTful\Rodson\TestInstructions\Domain\Containers\Samples;

interface TestSampleInstruction {
    public function hasInstructions();
    public function getInstructions();
    public function hasComparison();
    public function getComparison();
}
