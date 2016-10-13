<?php
namespace iRESTful\Rodson\Domain\Outputs\Methods\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\DSLs\Domain\Projects\Types\Type;

interface MethodAdapter {
    public function fromDataToMethods(array $data);
    public function fromDataToMethod(array $data);
    public function fromPropertiesToMethods(array $properties);
    public function fromPropertyToMethod(Property $property);
    public function fromTypeToMethods(Type $type);
    public function fromTypeToDatabaseAdapterMethod(Type $type);
    public function fromTypeToViewAdapterMethod(Type $type);
}
