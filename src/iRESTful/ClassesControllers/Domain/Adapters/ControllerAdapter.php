<?php
namespace iRESTful\ClassesControllers\Domain\Adapters;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;

interface ControllerAdapter {
    public function fromDSLControllersToControllers(array $controllers);
    public function fromDSLControllerToController(Controller $controller);
}
