<?php
namespace iRESTful\Rodson\Annotations\Domain\Parameters\Converters\Singles\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;

interface SingleConverterAdapter {
    public function fromTypeToDatabaseSingleConverter(Type $type);
    public function fromTypeToViewSingleConverter(Type $type);
}
