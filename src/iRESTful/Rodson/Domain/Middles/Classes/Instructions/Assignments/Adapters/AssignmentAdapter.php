<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Adapters;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;

interface AssignmentAdapter {
    public function fromControllerToAssignment(Controller $controller);
}
