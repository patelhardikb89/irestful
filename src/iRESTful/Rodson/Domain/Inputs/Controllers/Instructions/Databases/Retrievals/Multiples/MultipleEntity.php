<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Databases\Retrievals\Multiples;

interface MultipleEntity {
    public function getObject();
    public function hasUuids();
    public function getUuidValues();
    public function hasKeynames();
    public function getKeynames();
}
