<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Entities;

interface Entity {
    public function getContainer();
    public function hasUuidValue();
    public function getUuidValue();
    public function hasKeyname();
    public function getKeyname();
}
