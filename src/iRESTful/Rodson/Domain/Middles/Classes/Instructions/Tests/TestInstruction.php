<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests;

interface TestInstruction {
    public function hasInstructions();
    public function getInstructions();
    public function hasContainerInstructions();
    public function getContainerInstructions();
    public function hasInput();
    public function getInput();
}
