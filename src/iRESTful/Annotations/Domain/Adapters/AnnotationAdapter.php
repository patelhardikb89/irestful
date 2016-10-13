<?php
namespace iRESTful\Annotations\Domain\Adapters;
use iRESTful\ClassesEntities\Domain\Entity;

interface AnnotationAdapter {
    public function fromEntityToAnnotation(Entity $entity);
}
