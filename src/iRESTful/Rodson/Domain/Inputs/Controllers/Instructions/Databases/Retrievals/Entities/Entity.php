<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Databases\Retrievals\Entities;

interface Entity {
    public function getObject();
    public function hasUuid();
    public function getUuidValue();
    public function hasKeyname();
    public function getKeyname();
}
