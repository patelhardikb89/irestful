<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface ComplexEntityInterface extends Entity {
    public function getSlug();
    public function getName();
    public function getDescription();
    public function getSimpleEntity();
    public function getSimpleEntities();
}
