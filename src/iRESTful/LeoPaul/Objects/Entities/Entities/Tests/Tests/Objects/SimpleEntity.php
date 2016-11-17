<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface SimpleEntity extends Entity {
    public function getTitle();
    public function getDescription();
    public function hasSubEntities();
    public function getSubEntities();
    public function notAGetter();
}
