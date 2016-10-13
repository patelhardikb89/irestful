<?php
namespace iRESTful\Instructions\Domain\Adapters;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;

interface InstructionAdapter {
    public function fromDataToInstructions(array $data);
    public function fromDSLControllerToInstructions(Controller $controller);
}
