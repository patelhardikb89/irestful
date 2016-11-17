<?php
namespace iRESTful\Rodson\ClassesObjects\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;

interface ObjectAdapter {
    public function fromDSLObjectToObject(Object $object);
    public function fromDSLObjectsToObjects(array $objects);
}
