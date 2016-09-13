<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Singles\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;

interface SingleConverterAdapter {
    public function fromTypeToDatabaseSingleConverter(Type $type);
    public function fromTypeToViewSingleConverter(Type $type);
}
