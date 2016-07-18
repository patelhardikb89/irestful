<?php
namespace iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;

interface ParameterAdapter {
    public function fromDataToParameter(array $data);
    public function fromTypeToParameter(Type $type);
    public function fromTypesToParameters(array $types);
    public function fromPropertyToParameter(Property $property);
    public function fromPropertiesToParameters(array $properties);
}
