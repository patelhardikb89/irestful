<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;

interface InstructionAdapter {
    public function fromControllerToInstructions(Controller $controller);
}