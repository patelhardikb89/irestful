<?php
namespace iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Parameters\Types\Adapters;

interface TypeAdapter {
    public function fromDataToType(array $data);
}
