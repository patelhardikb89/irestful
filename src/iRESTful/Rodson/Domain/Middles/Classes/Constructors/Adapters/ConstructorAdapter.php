<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;

interface ConstructorAdapter {
    public function fromControllerToConstructor(Controller $controller);
    public function fromObjectToConstructor(Object $object);
    public function fromTypeToConstructor(Type $type);
    public function fromTypeToAdapterConstructor(Type $type);
}
