<?php
namespace iRESTful\Rodson\Domain\Outputs\Classes\Methods\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;

interface MethodAdapter {
    public function fromObjectToConstructor(Object $object);
    public function fromObjectToMethods(Object $object);
}
