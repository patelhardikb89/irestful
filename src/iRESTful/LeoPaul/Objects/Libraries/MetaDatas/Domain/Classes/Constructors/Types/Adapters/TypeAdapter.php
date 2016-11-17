<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Adapters;

interface TypeAdapter {
    public function fromDataToType(array $data);
}
