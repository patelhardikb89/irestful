<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface MethodAdapter {
    public function fromDataToMethods(array $data);
    public function fromDataToMethod(array $data);
    public function fromPropertiesToMethods(array $properties);
    public function fromPropertyToMethod(Property $property);
    public function fromTypeToMethods(Type $type);
}
