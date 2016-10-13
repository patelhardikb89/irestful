<?php
namespace iRESTful\Classes\Domain\Constructors\Parameters\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\Instructions\Domain\Instruction;

interface ParameterAdapter {
    public function fromInstructionsToParameters(array $instructions);
    public function fromInstructionToParameters(Instruction $instruction);
    public function fromObjectToParameters(Object $object);
    public function fromTypeToParameter(Type $type);
    public function fromPropertyToParameter(Property $property);
}
