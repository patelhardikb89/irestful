<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface RequestEntityAdapter {
    public function fromEntityToInsertRequests(Entity $entity);
    public function fromEntitiesToInsertRequests(array $entities);
    public function fromEntityToUpdateRequests(Entity $originalEntity, Entity $updatedEntity);
    public function fromEntitiesToUpdateRequests(array $originalEntities, array $updatedEntities);
    public function fromEntityToDeleteRequests(Entity $entity);
    public function fromEntitiesToDeleteRequests(array $entities);
    public function fromEntityToParentDeleteRequests(Entity $entity);
    public function fromEntitiesToParentDeleteRequests(array $entities);
}
