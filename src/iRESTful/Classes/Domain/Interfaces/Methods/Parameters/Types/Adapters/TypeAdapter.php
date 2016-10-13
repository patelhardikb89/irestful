<?php
namespace iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Types\Adapters;

interface TypeAdapter {
    public function fromDataToType(array $data);
}
