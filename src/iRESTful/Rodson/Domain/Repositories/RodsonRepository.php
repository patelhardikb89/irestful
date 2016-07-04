<?php
namespace iRESTful\Rodson\Domain\Repositories;

interface RodsonRepository {
    public function retrieve(array $criteria);
}
