<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface Owner extends Entity {
    public function getSoftware();
    public function getUser();
}

