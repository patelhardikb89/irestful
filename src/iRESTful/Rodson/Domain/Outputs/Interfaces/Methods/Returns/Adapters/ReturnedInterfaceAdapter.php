<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Returns\Adapters;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;

interface ReturnedInterfaceAdapter {
    public function fromTypeToReturnedInterface(Type $type);
    public function fromPropertyTypeToReturnedInterface(PropertyType $type);
}
