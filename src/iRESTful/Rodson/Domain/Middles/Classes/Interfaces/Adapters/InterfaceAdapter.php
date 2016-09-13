<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Controller;

interface InterfaceAdapter {
    public function fromControllerToInterface(Controller $controller);
    public function fromObjectToInterface(Object $object);
    public function fromTypeToInterface(Type $type);
    public function fromTypeToAdapterInterface(Type $type);
}
