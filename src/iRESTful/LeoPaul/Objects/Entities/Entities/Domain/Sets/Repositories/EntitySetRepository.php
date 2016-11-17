<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories;

interface EntitySetRepository {
    public function retrieve(array $criteria);
}
