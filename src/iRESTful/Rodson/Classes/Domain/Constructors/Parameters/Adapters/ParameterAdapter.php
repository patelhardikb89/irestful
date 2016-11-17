<?php
namespace iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\Instructions\Domain\Instruction;

interface ParameterAdapter {
    public function fromInstructionsToParameters(array $instructions);
    public function fromInstructionToParameters(Instruction $instruction);
    public function fromObjectToParameters(Object $object);
    public function fromTypeToParameter(Type $type);
    public function fromPropertyToParameter(Property $property);
}
