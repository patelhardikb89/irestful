<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Annotations;

interface AnnotatedObject {
    public function getObject();
    public function getAnnotationParameters();
    public function getData();
}
