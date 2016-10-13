<?php
namespace iRESTful\ClassesEntities\Domain\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Object;

interface EntityAdapter {
    public function fromDSLObjectToEntity(Object $object);
    public function fromDSLObjectsToEntities(array $objects);
}
