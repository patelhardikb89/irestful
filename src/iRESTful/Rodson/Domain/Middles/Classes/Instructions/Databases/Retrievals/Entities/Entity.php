<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities;

interface Entity {
    public function getClass();
    public function hasUuidValue();
    public function getUuidValue();
    public function hasKeyname();
    public function getKeyname();
}
