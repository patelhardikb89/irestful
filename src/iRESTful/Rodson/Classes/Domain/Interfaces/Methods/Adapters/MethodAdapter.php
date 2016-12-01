<?php
namespace iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;

interface MethodAdapter {
    public function fromNameToMethod($name);
    public function fromObjectToMethods(Object $object);
    public function fromTypeToMethod(Type $type);
    public function fromTypeToAdapterMethods(Type $type);
    public function fromObjectToAdapterMethods(Object $object);
    public function fromControllerToMethod(Controller $controller);
}
