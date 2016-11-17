<?php
namespace iRESTful\Rodson\Annotations\Domain\Parameters\Adapters;
use iRESTful\Rodson\ClassesEntities\Domain\Entity;
use iRESTful\Rodson\ClassesObjects\Domain\Object;

interface ParameterAdapter {
    public function fromEntityToParameters(Entity $entity);
    public function fromObjectToParameters(Object $object);
}
