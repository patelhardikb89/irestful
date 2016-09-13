<?php
namespace iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;

interface ParameterAdapter {
    public function fromDataToParameter(array $data);
    public function fromTypeToParameter(Type $type);
    public function fromTypesToParameters(array $types);
    public function fromPropertyToParameter(Property $property);
    public function fromPropertiesToParameters(array $properties);
    public function fromObjectToParameters(Object $object);
}
