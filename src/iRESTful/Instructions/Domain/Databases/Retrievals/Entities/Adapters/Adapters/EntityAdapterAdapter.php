<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Entities\Adapters\Adapters;

interface EntityAdapterAdapter {
    public function fromDataToEntityAdapter(array $data);
}
