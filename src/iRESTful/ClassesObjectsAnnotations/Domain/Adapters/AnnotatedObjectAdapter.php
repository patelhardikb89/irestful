<?php
namespace iRESTful\ClassesObjectsAnnotations\Domain\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Object;

interface AnnotatedObjectAdapter {
    public function fromDSLObjectsToAnnotatedClassObjects(array $objects);
    public function fromDSLObjectToAnnotatedClassObject(Object $inputObject);
}
