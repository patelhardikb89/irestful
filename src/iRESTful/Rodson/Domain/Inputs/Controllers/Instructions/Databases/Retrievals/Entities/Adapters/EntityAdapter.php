<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Databases\Retrievals\Entities\Adapters;

interface EntityAdapter {
    public function fromStringToEntity($string);
}
