<?php
namespace iRESTful\Rodson\ClassesObjectsAnnotations\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;

interface AnnotatedObjectAdapter {
    public function fromDSLObjectsToAnnotatedClassObjects(array $objects);
    public function fromDSLObjectToAnnotatedClassObject(Object $inputObject);
}
