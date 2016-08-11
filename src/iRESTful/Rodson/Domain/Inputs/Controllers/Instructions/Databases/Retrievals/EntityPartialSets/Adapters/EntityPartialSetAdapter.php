<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\Instructions\Databases\Retrievals\EntityPartialSets\Adapters;

interface EntityPartialSetAdapter {
    public function fromStringToEntityPartialSet($string);
}
