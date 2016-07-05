<?php
namespace iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapter;

interface MethodAdapter {
    public function fromDataToMethods(array $data);
    public function fromDataToMethod(array $data);
    public function fromPropertiesToMethods(array $properties);
    public function fromPropertyToMethod(Property $property);
    public function fromAdapterToMethod(Adapter $adapter);
}
