<?php
namespace iRESTful\Rodson\Domain\Outputs\Classes\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface ClassAdapter {
    public function fromObjectToClass(Object $object);
    public function fromObjectsToClasses(array $objects);
    public function fromObjectsToTypeClasses(array $objects);
    public function fromTypesToTypeClasses(array $types);
    public function fromTypeToTypeClass(Type $type);
    public function fromControllerToClass(Controller $controller);
    public function fromControllersToClasses(array $controllers);
    public function fromTypeToAdapterClass(Type $type);
}
