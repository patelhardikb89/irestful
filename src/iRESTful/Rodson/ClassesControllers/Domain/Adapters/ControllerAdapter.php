<?php
namespace iRESTful\Rodson\ClassesControllers\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;

interface ControllerAdapter {
    public function fromDSLControllersToControllers(array $controllers);
    public function fromDSLControllerToController(Controller $controller);
}
