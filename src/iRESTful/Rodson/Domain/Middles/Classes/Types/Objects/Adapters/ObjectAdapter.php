<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;

interface ObjectAdapter {
    public function fromObjectToObject(Object $object);
}
