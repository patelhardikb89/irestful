<?php
namespace iRESTful\TestInstructions\Domain\Containers\Samples;

interface TestSampleInstruction {
    public function hasInstructions();
    public function getInstructions();
    public function hasComparison();
    public function getComparison();
}
