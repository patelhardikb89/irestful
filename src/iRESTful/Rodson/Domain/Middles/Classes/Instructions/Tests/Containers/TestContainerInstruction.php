<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers;

interface TestContainerInstruction {
    public function hasInstructions();
    public function getInstructions();
    public function hasSampleInstructions();
    public function getSampleInstructions();
    public function hasComparison();
    public function getComparison();
}
