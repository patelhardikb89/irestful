<?php
namespace iRESTful\Rodson\Annotations\Domain\Adapters;
use iRESTful\Rodson\ClassesEntities\Domain\Entity;

interface AnnotationAdapter {
    public function fromEntityToAnnotation(Entity $entity);
}
