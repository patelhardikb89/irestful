<?php
namespace iRESTful\Classes\Domain\Constructors\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Types\Type;

interface ConstructorAdapter {
    public function fromInstructionsToConstructor(array $instructions);
    public function fromObjectToConstructor(Object $object);
    public function fromTypeToConstructor(Type $type);
    public function fromTypeToAdapterConstructor(Type $type);
}
