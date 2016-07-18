<?php
namespace iRESTful\Rodson\Domain\Outputs\Classes\Methods\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface MethodAdapter {
    public function fromEmptyToConstructor();
    public function fromTypeToCustomMethods(Type $type);
    public function fromObjectToConstructor(Object $object);
    public function fromObjectToMethods(Object $object);
    public function fromTypeToConstructor(Type $type);
    public function fromTypeToMethods(Type $type);
}
