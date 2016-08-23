<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Classes;

interface AnnotatedClass {
    public function getClass();
    public function hasAnnotation();
    public function getAnnotation();
    public function hasSamples();
    public function getSamples();
    public function getData();
}
