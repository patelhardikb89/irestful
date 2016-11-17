<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;

interface EntityAdapterAdapter {
    public function fromRepositoriesToEntityAdapter(EntityRepository $repository, EntityRelationRepository $entityRelationRepository);
}
