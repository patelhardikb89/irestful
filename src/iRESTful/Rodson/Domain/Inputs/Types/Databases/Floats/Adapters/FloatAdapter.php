<?php
namespace iRESTful\Rodson\Domain\Inputs\Types\Databases\Floats\Adapters;

interface FloatAdapter {
    public function fromDataToFloat(array $data);
}
