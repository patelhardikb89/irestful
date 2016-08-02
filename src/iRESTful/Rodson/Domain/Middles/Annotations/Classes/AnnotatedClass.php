<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Classes;

interface AnnotatedClass {
    public function getClass();
    public function hasAnnotation();
    public function getAnnotation();
}
