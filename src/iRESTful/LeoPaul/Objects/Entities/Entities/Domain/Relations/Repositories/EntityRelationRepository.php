<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories;

interface EntityRelationRepository {
    public function retrieve(array $criteria);
}
