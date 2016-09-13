<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Controller;

interface ControllerAdapter {
    public function fromControllersToSpecificControllers(array $controllers);
    public function fromControllerToSpecificController(Controller $controller);
}
