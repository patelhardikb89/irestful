<?php
namespace iRESTful\Rodson\Annotations\Domain\Parameters\Types\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property;

interface TypeAdapter {
    public function fromObjectPropertyToType(Property $objectProperty);
}
