<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Values\Adapters\Adapters;

interface ValueAdapterAdapter {
    public function fromDataToValueAdapter(array $data);
}
