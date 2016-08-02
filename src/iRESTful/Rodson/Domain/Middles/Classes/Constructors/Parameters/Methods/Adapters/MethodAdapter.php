<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Methods\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface MethodAdapter {
    public function fromPropertyToMethod(Property $property);
    public function fromTypeToMethod(Type $type);
}
