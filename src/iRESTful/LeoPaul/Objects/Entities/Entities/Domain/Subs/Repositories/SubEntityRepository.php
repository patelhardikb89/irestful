<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface SubEntityRepository {
    public function retrieve(Entity $entity);
}
