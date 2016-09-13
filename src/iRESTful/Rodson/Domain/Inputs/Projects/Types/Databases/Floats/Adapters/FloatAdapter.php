<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Floats\Adapters;

interface FloatAdapter {
    public function fromDataToFloat(array $data);
}
