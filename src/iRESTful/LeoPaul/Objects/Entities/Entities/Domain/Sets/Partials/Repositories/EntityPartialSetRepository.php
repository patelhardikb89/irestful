<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories;

interface EntityPartialSetRepository {
    public function retrieve(array $criteria);
}
