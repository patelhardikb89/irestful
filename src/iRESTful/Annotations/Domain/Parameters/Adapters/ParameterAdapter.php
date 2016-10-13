<?php
namespace iRESTful\Annotations\Domain\Parameters\Adapters;
use iRESTful\ClassesEntities\Domain\Entity;
use iRESTful\ClassesObjects\Domain\Object;

interface ParameterAdapter {
    public function fromEntityToParameters(Entity $entity);
    public function fromObjectToParameters(Object $object);
}
