<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Controller;

interface TestInstructionAdapter {
    public function fromControllerToTestInstructions(Controller $controller);
}
