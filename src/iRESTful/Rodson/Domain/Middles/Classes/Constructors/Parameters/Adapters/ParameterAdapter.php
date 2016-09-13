<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Instruction;

interface ParameterAdapter {
    public function fromInstructionsToParameters(array $instructions);
    public function fromInstructionToParameters(Instruction $instruction);
    public function fromObjectToParameters(Object $object);
    public function fromTypeToParameter(Type $type);
    public function fromPropertyToParameter(Property $property);
}
