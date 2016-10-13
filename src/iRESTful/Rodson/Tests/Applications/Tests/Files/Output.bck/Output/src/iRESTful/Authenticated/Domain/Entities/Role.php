<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface Role extends Entity {
    public function getTitle();
    public function getDescription();
    public function getPermissions();
}

