<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Values\Adapters\Adapters;

interface ValueAdapterAdapter {
    public function fromDataToValueAdapter(array $data);
}
