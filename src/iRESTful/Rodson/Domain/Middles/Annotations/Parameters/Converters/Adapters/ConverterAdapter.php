<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;

interface ConverterAdapter {
    public function fromTypeToConverter(Type $type);
}
