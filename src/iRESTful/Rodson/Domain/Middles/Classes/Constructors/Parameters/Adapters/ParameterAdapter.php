<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface ParameterAdapter {
    public function fromObjectToParameters(Object $object);
    public function fromTypeToParameter(Type $type);
    public function fromPropertyToParameter(Property $property);
}
