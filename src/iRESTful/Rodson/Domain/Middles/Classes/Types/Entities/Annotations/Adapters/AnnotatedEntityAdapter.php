<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\Adapters;

interface AnnotatedEntityAdapter {
    public function fromObjectsToAnnotatedEntities(array $objects);
}
