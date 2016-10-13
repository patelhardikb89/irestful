<?php
namespace iRESTful\Annotations\Domain\Parameters\Converters\Adapters;
use iRESTful\DSLs\Domain\Projects\Types\Type;

interface ConverterAdapter {
    public function fromTypeToConverter(Type $type);
}
