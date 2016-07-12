<?php
namespace iRESTful\Rodson\Domain\Outputs\Classes\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;

interface ClassAdapter {
    public function fromObjectToClass(Object $object);
    public function fromControllerToClass(Controller $controller);
}
