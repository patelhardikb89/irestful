<?php
namespace iRESTful\Rodson\ClassesEntitiesAnnotations\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Entity;

interface AnnotatedEntityAdapter {
    public function fromDSLEntityToAnnotatedEntity(Entity $entity);
    public function fromDSLEntitiesToAnnotatedEntities(array $entities);
}
