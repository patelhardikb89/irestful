<?php
namespace iRESTful\Authenticated\Domain\Entities;
use iRESTful\Objects\Entities\Entities\Domain\Entity;

interface Permission extends Entity {
    public function getTitle();
    public function getCan_read();
    public function getCan_write();
    public function getCan_delete();
    public function getDescription();
}

