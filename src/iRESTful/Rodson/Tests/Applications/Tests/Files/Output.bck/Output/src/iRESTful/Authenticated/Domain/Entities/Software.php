<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface Software extends Entity {
    public function getName();
    public function getCredentials();
    public function getRoles();
}

