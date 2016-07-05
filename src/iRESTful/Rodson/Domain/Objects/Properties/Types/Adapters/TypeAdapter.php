<?php
namespace iRESTful\Rodson\Domain\Objects\Properties\Types\Adapters;

interface TypeAdapter {
    public function fromStringToType($string);
}
