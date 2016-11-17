<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Adapters;

interface TableAdapter {
    public function fromTablesToSQLQueries(array $tables);
}
