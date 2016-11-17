<?php
namespace iRESTful\Rodson\Annotations\Domain\Parameters\Converters\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;

interface ConverterAdapter {
    public function fromTypeToConverter(Type $type);
}
