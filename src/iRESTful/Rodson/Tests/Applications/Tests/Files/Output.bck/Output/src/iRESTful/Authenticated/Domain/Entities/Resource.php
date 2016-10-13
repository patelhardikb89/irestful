<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface Resource extends Entity {
    public function getEndpoint();
    public function getOwner();
    public function getShared_resources();
}

