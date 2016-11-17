<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Subs\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities;

interface SubEntitiesAdapter {
    public function fromSubEntitiesToRequests(SubEntities $subEntities);
}
