<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;

interface EntityAdapter {
    public function fromObjectToEntity(Object $object);
}
