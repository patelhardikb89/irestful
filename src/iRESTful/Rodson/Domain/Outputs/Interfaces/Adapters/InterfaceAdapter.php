<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;

interface InterfaceAdapter {
    public function fromObjectToInterface(Object $object);
    public function fromTypeToInterface(Type $type);
    public function fromPropertyTypeToInterface(PropertyType $propertyType);
    public function fromPropertyTypesToInterfaces(array $propertyTypes);
}
