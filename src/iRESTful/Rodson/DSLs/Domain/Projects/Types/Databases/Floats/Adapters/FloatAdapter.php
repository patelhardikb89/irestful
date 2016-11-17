<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Floats\Adapters;

interface FloatAdapter {
    public function fromDataToFloat(array $data);
}
