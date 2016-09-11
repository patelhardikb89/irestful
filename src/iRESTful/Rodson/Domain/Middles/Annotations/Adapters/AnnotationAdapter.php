<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Entity;

interface AnnotationAdapter {
    public function fromEntityToAnnotation(Entity $entity);
}
