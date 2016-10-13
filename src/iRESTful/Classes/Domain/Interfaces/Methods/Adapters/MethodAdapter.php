<?php
namespace iRESTful\Classes\Domain\Interfaces\Methods\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\Classes\Domain\Methods\Customs\CustomMethod;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;

interface MethodAdapter {
    public function fromNameToMethod($name);
    public function fromObjectToMethods(Object $object);
    public function fromTypeToMethod(Type $type);
    public function fromTypeToAdapterMethods(Type $type);
    public function fromControllerToMethod(Controller $controller);
}
