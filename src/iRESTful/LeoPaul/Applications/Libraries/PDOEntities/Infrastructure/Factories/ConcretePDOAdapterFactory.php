<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Factories\PDOAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcretePDOAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;

final class ConcretePDOAdapterFactory implements PDOAdapterFactory {
    private $entityAdapterAdapter;
    private $entityRepository;
    private $entityRelationRepository;
    public function __construct(EntityAdapterAdapter $entityAdapterAdapter, EntityRepository $entityRepository, EntityRelationRepository $entityRelationRepository) {
        $this->entityAdapterAdapter = $entityAdapterAdapter;
        $this->entityRepository = $entityRepository;
        $this->entityRelationRepository = $entityRelationRepository;
    }

    public function create() {
        return new ConcretePDOAdapter($this->entityAdapterAdapter, $this->entityRepository, $this->entityRelationRepository);
    }

}
