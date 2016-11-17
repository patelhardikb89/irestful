<?php
namespace iRESTful\Rodson\TestInstructions\Domain;

interface TestInstruction {
    public function hasInstructions();
    public function getInstructions();
    public function hasContainerInstructions();
    public function getContainerInstructions();
    public function hasInput();
    public function getInput();
}
