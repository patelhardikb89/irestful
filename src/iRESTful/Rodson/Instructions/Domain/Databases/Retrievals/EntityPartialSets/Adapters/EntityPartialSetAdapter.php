<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\EntityPartialSets\Adapters;

interface EntityPartialSetAdapter {
    public function fromDataToEntityPartialSet(array $data);
}
