<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;

interface InputAdapter {
    public function fromControllerToInput(Controller $controller);
    public function fromObjectToInput(Object $object);
    public function fromTypeToInput(Type $type);
}
