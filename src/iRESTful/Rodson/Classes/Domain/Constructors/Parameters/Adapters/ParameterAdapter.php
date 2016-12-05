<?php
namespace iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;

interface ParameterAdapter {
    public function fromControllerToParameters(Controller $controller);
    public function fromObjectToParameters(Object $object);
    public function fromTypeToParameter(Type $type);
    public function fromPropertyToParameter(Property $property);
}
