<?php
namespace iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Methods\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;

interface MethodAdapter {
    public function fromPropertyToMethod(Property $property);
    public function fromTypeToMethod(Type $type);
}
