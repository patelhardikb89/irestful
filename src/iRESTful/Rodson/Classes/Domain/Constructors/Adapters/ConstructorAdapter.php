<?php
namespace iRESTful\Rodson\Classes\Domain\Constructors\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;

interface ConstructorAdapter {
    public function fromControllerToConstructor(Controller $controller);
    public function fromObjectToConstructor(Object $object);
    public function fromTypeToConstructor(Type $type);
    public function fromTypeToAdapterConstructor(Type $type);
    public function fromObjectToAdapterConstructor(Object $object);
}
