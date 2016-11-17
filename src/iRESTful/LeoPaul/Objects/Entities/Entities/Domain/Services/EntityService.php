<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface EntityService {
    public function insert(Entity $entity);
    public function update(Entity $originalEntity, Entity $updatedEntity);
    public function delete(Entity $entity);
}
