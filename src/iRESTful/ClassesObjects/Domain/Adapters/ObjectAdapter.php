<?php
namespace iRESTful\ClassesObjects\Domain\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Object;

interface ObjectAdapter {
    public function fromDSLObjectToObject(Object $object);
    public function fromDSLObjectsToObjects(array $objects);
}
