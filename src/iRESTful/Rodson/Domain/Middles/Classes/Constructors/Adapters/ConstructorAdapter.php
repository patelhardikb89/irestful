<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;

interface ConstructorAdapter {
    public function fromInstructionsToConstructor(array $instructions);
    public function fromObjectToConstructor(Object $object);
    public function fromTypeToConstructor(Type $type);
    public function fromTypeToAdapterConstructor(Type $type);
}
