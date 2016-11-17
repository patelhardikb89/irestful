<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

interface SubEntities {
    public function hasExistingEntities();
    public function getExistingEntities();
    public function hasNewEntities();
    public function getNewEntities();
    public function getNewEntityIndex(Entity $entity);
    public function getExistingEntityIndex(Entity $entity);
    public function merge(SubEntities $subEntities);
    public function delete(SubEntities $subEntities);
}
