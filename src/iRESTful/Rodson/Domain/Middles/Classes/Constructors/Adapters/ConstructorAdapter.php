<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface ConstructorAdapter {
    public function fromObjectToConstructor(Object $object);
    public function fromTypeToConstructor(Type $type);
    public function fromTypeToAdapterConstructor(Type $type);
}
