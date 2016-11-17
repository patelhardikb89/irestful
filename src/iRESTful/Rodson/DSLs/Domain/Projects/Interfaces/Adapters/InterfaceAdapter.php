<?php
namespace iRESTful\Rodson\Classes\Domain\Interfaces\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Types\Type as PropertyType;

interface InterfaceAdapter {
    public function fromObjectToInterface(Object $object);
    public function fromTypeToInterface(Type $type);
    public function fromTypeToAdapterInterface(Type $type);
    public function fromPropertiesToInterfaces(array $properties);
    public function fromPropertyTypeToInterface(PropertyType $propertyType);
}
