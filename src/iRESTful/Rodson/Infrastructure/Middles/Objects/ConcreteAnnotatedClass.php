<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Middles\Annotations\Annotation;

final class ConcreteAnnotatedClass implements AnnotatedClass {
    private $class;
    private $annotation;
    public function __construct(ObjectClass $class, Annotation $annotation = null) {
        $this->class = $class;
        $this->annotation = $annotation;
    }

    public function getClass() {
        return $this->class;
    }

    public function hasAnnotation() {
        return !empty($this->annotation);
    }

    public function getAnnotation() {
        return $this->annotation;
    }

}
