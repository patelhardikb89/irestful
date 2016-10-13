<?php
namespace iRESTful\TestInstructions\Domain\Adapters;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;

interface TestInstructionAdapter {
    public function fromDSLControllerToTestInstructions(Controller $controller);
}
