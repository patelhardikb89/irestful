<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories;

interface EntityRepository {
    public function exists(array $criteria);
    public function retrieve(array $criteria);
}
