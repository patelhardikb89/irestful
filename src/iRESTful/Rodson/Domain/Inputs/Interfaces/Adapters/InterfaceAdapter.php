<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;

interface InterfaceAdapter {
    public function fromObjectToInterface(Object $object);
    public function fromTypeToInterface(Type $type);
    public function fromTypeToAdapterInterface(Type $type);
    public function fromPropertiesToInterfaces(array $properties);
    public function fromPropertyTypeToInterface(PropertyType $propertyType);
}
