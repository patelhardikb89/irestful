<?php
namespace iRESTful\Rodson\Domain\Inputs\Repositories;

interface RodsonRepository {
    public function retrieve(array $criteria);
}
