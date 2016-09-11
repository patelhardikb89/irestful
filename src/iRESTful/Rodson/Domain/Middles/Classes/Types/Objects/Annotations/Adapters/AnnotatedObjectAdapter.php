<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Annotations\Adapters;

interface AnnotatedObjectAdapter {
    public function fromObjectsToAnnotatedObjects(array $objects);
}
