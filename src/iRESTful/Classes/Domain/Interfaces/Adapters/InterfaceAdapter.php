<?php
namespace iRESTful\Classes\Domain\Interfaces\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;

interface InterfaceAdapter {
    public function fromControllerToInterface(Controller $controller);
    public function fromObjectToInterface(Object $object);
    public function fromTypeToInterface(Type $type);
    public function fromTypeToAdapterInterface(Type $type);
}
