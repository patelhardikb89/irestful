<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Fields\Types\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;

interface TypeAdapter {
    public function fromTypeToTypeInSqlQueryLine(Type $type);
}
