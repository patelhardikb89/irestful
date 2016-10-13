<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface Registration extends Entity {
    public function getKeyname();
    public function getTitle();
    public function getDescription();
    public function getRoles();
}

