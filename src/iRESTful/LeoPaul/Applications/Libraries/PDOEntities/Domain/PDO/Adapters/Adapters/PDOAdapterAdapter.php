<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;

interface PDOAdapterAdapter {
    public function fromEntityRepositoryToPDOAdapter(EntityRepository $entityRepository);
    public function fromEntityRelationRepositoryToPDOAdapter(EntityRelationRepository $entityRelationRepository);
}
