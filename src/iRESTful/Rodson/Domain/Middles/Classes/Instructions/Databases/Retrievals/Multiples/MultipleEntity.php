<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples;

interface MultipleEntity {
    public function getClass();
    public function hasUuidValues();
    public function getUuidValues();
    public function hasKeynames();
    public function getKeynames();
}
