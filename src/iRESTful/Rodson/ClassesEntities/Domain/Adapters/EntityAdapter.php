<?php
namespace iRESTful\Rodson\ClassesEntities\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Entity;

interface EntityAdapter {
    public function fromDSLEntityToEntity(Entity $entity);
    public function fromDSLEntitiesToEntities(array $entities);
}
