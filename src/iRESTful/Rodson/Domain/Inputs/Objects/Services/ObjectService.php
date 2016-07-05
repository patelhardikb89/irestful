<?php
namespace iRESTful\Rodson\Domain\Inputs\Objects\Services;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;

interface ObjectService {
    public function save(Object $object);
    public function saveMultiple(array $objects);
}
