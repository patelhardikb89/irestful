<?php
namespace iRESTful\Classes\Domain\Constructors\Parameters\Methods\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\DSLs\Domain\Projects\Types\Type;

interface MethodAdapter {
    public function fromPropertyToMethod(Property $property);
    public function fromTypeToMethod(Type $type);
}
