<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface Params extends Entity {
    public function getName();
    public function getPattern();
    public function getIs_mandatory();
}

