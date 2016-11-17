<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Adapters\PDOAdapterAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcretePDOAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;

final class ConcretePDOAdapterAdapter implements PDOAdapterAdapter {
    private $entityAdapterAdapter;
    private $entityRepository;
    private $entityRelationRepository;
    public function __construct(
        EntityAdapterAdapter $entityAdapterAdapter,
        EntityRepository $entityRepository = null,
        EntityRelationRepository $entityRelationRepository = null
    ) {
        $this->entityAdapterAdapter = $entityAdapterAdapter;
        $this->entityRepository = $entityRepository;
        $this->entityRelationRepository = $entityRelationRepository;
    }
    
    public function fromEntityRepositoryToPDOAdapter(EntityRepository $entityRepository) {
        return new ConcretePDOAdapter($this->entityAdapterAdapter, $entityRepository, $this->entityRelationRepository);
    }

    public function fromEntityRelationRepositoryToPDOAdapter(EntityRelationRepository $entityRelationRepository) {
        return new ConcretePDOAdapter($this->entityAdapterAdapter, $this->entityRepository, $entityRelationRepository);
    }

}
