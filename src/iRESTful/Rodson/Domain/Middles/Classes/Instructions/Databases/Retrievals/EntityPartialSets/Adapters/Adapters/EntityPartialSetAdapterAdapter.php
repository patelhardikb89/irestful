<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Adapters\Adapters;

interface EntityPartialSetAdapterAdapter {
    public function fromDataToEntityPartialSetAdapter(array $data);
}
