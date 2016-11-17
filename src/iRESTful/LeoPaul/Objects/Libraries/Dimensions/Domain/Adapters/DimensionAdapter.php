<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Adapters;

interface DimensionAdapter {
    public function fromDataToDimension(array $data);
}
