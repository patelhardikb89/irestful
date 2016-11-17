<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Fields\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field;

interface FieldAdapter {
    public function fromFieldsToSQLQueryLines(array $fields);
    public function fromFieldToSQLQueryLine(Field $field);
}
