<?php
namespace iRESTful\Rodson\Domain\Outputs\Methods\Returns\Adapters;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;

interface ReturnedInterfaceAdapter {
    public function fromTypeToReturnedInterface(Type $type);
    public function fromObjectToReturnedInterface(Object $object);
    public function fromPropertyTypeToReturnedInterface(PropertyType $type);
}
