<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface SimpleEntityInterface extends Entity {
    public function getTitle();
    public function getDescription();
    public function notAGetter();
}
