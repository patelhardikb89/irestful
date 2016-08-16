<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Adapters;

interface EntityPartialSetAdapter {
    public function fromDataToEntityPartialSet(array $data);
}
