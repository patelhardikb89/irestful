<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;

interface MethodAdapter {
    public function fromNameToMethod($name);
    public function fromObjectToMethods(Object $object);
    public function fromTypeToMethod(Type $type);
    public function fromTypeToAdapterMethods(Type $type);
}
