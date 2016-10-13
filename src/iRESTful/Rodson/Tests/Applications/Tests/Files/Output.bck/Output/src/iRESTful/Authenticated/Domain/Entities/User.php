<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface User extends Entity {
    public function getName();
    public function getCredentials();
    public function getRoles();
}

