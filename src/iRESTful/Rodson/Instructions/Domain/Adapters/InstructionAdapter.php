<?php
namespace iRESTful\Rodson\Instructions\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;

interface InstructionAdapter {
    public function fromDataToInstructions(array $data);
    public function fromDSLControllerToInstructions(Controller $controller);
}
