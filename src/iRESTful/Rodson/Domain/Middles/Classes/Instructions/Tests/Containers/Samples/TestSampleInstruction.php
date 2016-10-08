<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers\Samples;

interface TestSampleInstruction {
    public function getInstructions();
    public function hasComparison();
    public function getComparison();
}
