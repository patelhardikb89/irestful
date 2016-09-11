<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations;

interface AnnotatedEntity {
    public function getEntity();
    public function getAnnotation();
    public function getData();
}
