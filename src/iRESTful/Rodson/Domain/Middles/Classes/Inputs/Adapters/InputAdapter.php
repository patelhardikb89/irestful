<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface InputAdapter {
    public function fromObjectToInput(Object $object);
    public function fromTypeToInput(Type $type);
}
