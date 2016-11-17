<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Adapters\SchemaAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Schema;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Adapters\TableAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Exceptions\SchemaException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;

final class PDOSchemaAdapter implements SchemaAdapter {
    private $tableAdapter;
    public function __construct(TableAdapter $tableAdapter) {
        $this->tableAdapter = $tableAdapter;
    }

    public function fromSchemaToSQLQueries(Schema $schema) {

        try {

            $tableQueries = [];
            $name = $schema->getName();
            if ($schema->hasTables()) {
                $tables = $schema->getTables();
                $tableQueries = $this->tableAdapter->fromTablesToSQLQueries($tables);
            }

            $queries = [
                'drop database if exists '.$name.';',
                'create database if not exists '.$name.';',
                'use '.$name.';'
            ];

            return array_merge($queries, $tableQueries);

        } catch (TableException $exception) {
            throw new SchemaException('There was an exception while converting Table objects to sql queries.', $exception);
        }
    }

}
