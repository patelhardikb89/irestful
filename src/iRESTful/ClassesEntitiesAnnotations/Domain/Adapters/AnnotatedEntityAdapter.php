<?php
namespace iRESTful\ClassesEntitiesAnnotations\Domain\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Object;

interface AnnotatedEntityAdapter {
    public function fromDSLObjectToAnnotatedEntity(Object $object);
    public function fromDSLObjectsToAnnotatedEntities(array $objects);
}
