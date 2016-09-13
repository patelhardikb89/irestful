<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Types\Adapters;

interface TypeAdapter {
    public function fromStringToType($string);
}
