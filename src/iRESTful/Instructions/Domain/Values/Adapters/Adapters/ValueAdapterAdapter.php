<?php
namespace iRESTful\Instructions\Domain\Values\Adapters\Adapters;

interface ValueAdapterAdapter {
    public function fromDataToValueAdapter(array $data);
}
