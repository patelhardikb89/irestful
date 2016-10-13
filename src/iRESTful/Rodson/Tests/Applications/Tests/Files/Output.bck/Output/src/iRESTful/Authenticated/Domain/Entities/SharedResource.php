<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface SharedResource extends Entity {
    public function getPermissions();
    public function getOwners();
}

