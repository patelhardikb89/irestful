<?php
namespace iRESTful\Rodson\Domain\Outputs\Classes\Properties\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property as ObjectProperty;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface PropertyAdapter {
    public function fromObjectToProperties(Object $object);
    public function fromObjectPropertyToProperty(ObjectProperty $objectProperty);
    public function fromTypeToProperty(Type $type);
}
