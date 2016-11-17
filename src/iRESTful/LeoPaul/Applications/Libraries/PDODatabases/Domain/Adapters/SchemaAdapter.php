<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Schema;

interface SchemaAdapter {
    public function fromSchemaToSQLQueries(Schema $schema);
}
