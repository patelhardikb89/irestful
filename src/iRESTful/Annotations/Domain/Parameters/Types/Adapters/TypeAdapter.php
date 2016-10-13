<?php
namespace iRESTful\Annotations\Domain\Parameters\Types\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Property;

interface TypeAdapter {
    public function fromObjectPropertyToType(Property $objectProperty);
}
