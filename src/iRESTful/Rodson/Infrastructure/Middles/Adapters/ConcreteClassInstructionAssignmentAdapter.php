<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Adapters\AssignmentAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;

final class ConcreteClassInstructionAssignmentAdapter implements AssignmentAdapter {

    public function __construct() {

    }

    public function fromControllerToAssignment(Controller $controller) {

        $instructions = $controller->getInstructions();

        print_r($instructions);
        die();

    }

}
