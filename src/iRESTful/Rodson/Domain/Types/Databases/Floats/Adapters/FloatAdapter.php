<?php
namespace iRESTful\Rodson\Domain\Types\Databases\Floats\Adapters;

interface FloatAdapter {
    public function fromDataToFloat(array $data);
}
