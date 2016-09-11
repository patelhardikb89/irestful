<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Entity;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Object;

interface ParameterAdapter {
    public function fromEntityToParameters(Entity $entity);
    public function fromObjectToParameters(Object $object);
}
