<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;

final class ConcreteEntityAdapterFactory implements EntityAdapterFactory {
    private $entityRepository;
    private $entityRelationRepository;
    private $entityAdapterAdapter;
    public function __construct(EntityRepository $entityRepository, EntityRelationRepository $entityRelationRepository, EntityAdapterAdapter $entityAdapterAdapter) {
        $this->entityRepository = $entityRepository;
        $this->entityRelationRepository = $entityRelationRepository;
        $this->entityAdapterAdapter = $entityAdapterAdapter;
    }

    public function create() {
        return $this->entityAdapterAdapter->fromRepositoriesToEntityAdapter($this->entityRepository, $this->entityRelationRepository);
    }

}
