<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities;

interface Entity {
    public function getContainer();
    public function hasUuidValue();
    public function getUuidValue();
    public function hasKeyname();
    public function getKeyname();
    public function getData();
}
