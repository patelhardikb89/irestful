<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Databases\Retrievals\Multiples\Adapters;

interface MultipleEntityAdapter {
    public function fromStringToEntities($string);
}
