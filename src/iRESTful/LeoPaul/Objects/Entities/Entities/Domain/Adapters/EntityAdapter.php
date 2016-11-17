<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface EntityAdapter {
    public function fromDataToEntity(array $data);
    public function fromDataToEntities(array $data);
    public function fromEntityToData(Entity $entity, $isHumanReadable);
    public function fromEntitiesToData(array $entities, $isHumanReadable);
    public function fromEntityToContainerName(Entity $entity);
    public function fromEntitiesToContainerNames(array $entities);
    public function fromEntityToSubEntities(Entity $entity);
    public function fromEntitiesToSubEntities(array $entities);
    public function fromEntityToRelationEntities(Entity $entity);
    public function fromEntitiesToRelationEntitiesList(array $entities);
    public function fromEntitiesToUniqueEntities(array $entities);
    public function fromObjectsToEntities(array $objects);
    public function fromRelationObjectsToRelationEntities(array $relationObjects);
    public function fromRelationObjectsListToRelationEntitiesList(array $relationObjectsList);
    public function fromEntityToEmptyRelationEntityKeynames(Entity $entity);
}
