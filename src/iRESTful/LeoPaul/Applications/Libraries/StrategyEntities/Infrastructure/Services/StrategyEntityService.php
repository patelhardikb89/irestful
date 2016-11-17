<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Services;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class StrategyEntityService implements EntityService {
    private $entityAdapter;
    private $containerServiceMapper;
    public function __construct(EntityAdapter $entityAdapter, array $containerServiceMapper) {
        $this->entityAdapter = $entityAdapter;
        $this->containerServiceMapper = $containerServiceMapper;
    }

    public function insert(Entity $entity) {
        $service = $this->fetchService($entity);
        $service->insert($entity);
    }

    public function update(Entity $originalEntity, Entity $updatedEntity) {
        $service = $this->fetchService($originalEntity);
        $service->update($originalEntity, $updatedEntity);
    }

    public function delete(Entity $entity) {
        $service = $this->fetchService($entity);
        $service->delete($entity);
    }

    private function fetchService(Entity $entity) {
        $containerName = $this->entityAdapter->fromEntityToContainerName($entity);
        if (!isset($this->containerServiceMapper[$containerName])) {
            throw new EntityException('The containerName ('.$containerName.') does not have a matching service in the mapper.');
        }

        return $this->containerServiceMapper[$containerName];
    }

}
