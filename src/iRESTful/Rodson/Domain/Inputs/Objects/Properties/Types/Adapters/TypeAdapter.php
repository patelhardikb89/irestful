<?php
namespace iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Adapters;

interface TypeAdapter {
    public function fromStringToType($string);
}
