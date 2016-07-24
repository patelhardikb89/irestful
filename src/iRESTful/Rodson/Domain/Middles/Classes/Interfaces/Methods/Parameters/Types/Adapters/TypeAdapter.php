<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Types\Adapters;

interface TypeAdapter {
    public function fromDataToType(array $data);
}
