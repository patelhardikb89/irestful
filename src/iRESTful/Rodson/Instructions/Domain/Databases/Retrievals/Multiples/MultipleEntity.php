<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Multiples;

interface MultipleEntity {
    public function getContainer();
    public function hasUuidValue();
    public function getUuidValue();
    public function hasKeyname();
    public function getKeyname();
}
