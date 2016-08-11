<?php
namespace iRESTful\Rodson\Domain\Inputs\Values\Adapters\Adapters;

interface ValueAdapterAdapter {
    public function fromDataToValueAdapter(array $data);
}
