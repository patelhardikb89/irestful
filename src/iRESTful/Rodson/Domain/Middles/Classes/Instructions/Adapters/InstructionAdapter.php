<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Controller;

interface InstructionAdapter {
    public function fromDataToInstructions(array $data);
    public function fromControllerToInstructions(Controller $controller);
}
