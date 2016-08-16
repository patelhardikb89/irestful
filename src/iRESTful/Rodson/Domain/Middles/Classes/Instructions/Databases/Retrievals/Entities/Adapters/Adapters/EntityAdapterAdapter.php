<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Adapters\Adapters;

interface EntityAdapterAdapter {
    public function fromDataToEntityAdapter(array $data);
}
