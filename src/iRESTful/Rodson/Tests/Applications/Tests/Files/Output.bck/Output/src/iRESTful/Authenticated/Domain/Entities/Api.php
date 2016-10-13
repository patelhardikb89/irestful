<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface Api extends Entity {
    public function getBase_url();
    public function getEndpoints();
}

