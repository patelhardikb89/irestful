<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;

interface AnnotationAdapter {
    public function fromClassToAnnotation(ObjectClass $class);
}
