<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Adapters;

interface EntityAdapter {
    public function fromStringToEntity($string);
}
