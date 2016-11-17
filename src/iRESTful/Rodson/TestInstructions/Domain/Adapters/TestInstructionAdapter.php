<?php
namespace iRESTful\Rodson\TestInstructions\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;

interface TestInstructionAdapter {
    public function fromDSLControllerToTestInstructions(Controller $controller);
}
