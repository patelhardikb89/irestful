<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services;

interface EntitySetService {
    public function insert(array $entities);
    public function update(array $originalEntities, array $updatedEntities);
    public function delete(array $entities);
}
