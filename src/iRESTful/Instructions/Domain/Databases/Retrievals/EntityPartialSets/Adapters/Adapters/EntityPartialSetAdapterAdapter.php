<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\EntityPartialSets\Adapters\Adapters;

interface EntityPartialSetAdapterAdapter {
    public function fromDataToEntityPartialSetAdapter(array $data);
}
