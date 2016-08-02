<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Types\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;

interface TypeAdapter {
    public function fromObjectPropertyToType(Property $objectProperty);
}
