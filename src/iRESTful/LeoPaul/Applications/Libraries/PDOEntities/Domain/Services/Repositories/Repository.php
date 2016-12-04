<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Repositories;

interface Repository {
    public function getEntity();
    public function getEntitySet();
    public function getEntityPartialSet();
    public function getEntityRelation();
}
