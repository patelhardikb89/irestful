<?php
namespace iRESTful\ClassesEntities\Domain\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Entities\Entity;

interface EntityAdapter {
    public function fromDSLEntityToEntity(Entity $entity);
    public function fromDSLEntitiesToEntities(array $entities);
}
