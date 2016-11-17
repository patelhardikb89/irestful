<?php
namespace iRESTful\ClassesEntitiesAnnotations\Domain\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Entities\Entity;

interface AnnotatedEntityAdapter {
    public function fromDSLEntityToAnnotatedEntity(Entity $entity);
    public function fromDSLEntitiesToAnnotatedEntities(array $entities);
}
