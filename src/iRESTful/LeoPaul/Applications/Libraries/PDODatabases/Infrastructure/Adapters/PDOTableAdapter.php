<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Adapters\TableAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Fields\Adapters\FieldAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Exceptions\FieldException;

final class PDOTableAdapter implements TableAdapter {
    private $fieldAdapter;
    public function __construct(FieldAdapter $fieldAdapter) {
        $this->fieldAdapter = $fieldAdapter;
    }

    public function fromTablesToSQLQueries(array $tables) {

        $createTables = [];
        $alterTables = [];
        $relations = [];
        foreach($tables as $oneTable) {
            $queries = $this->fromTableToSQLQueries($oneTable);
            $createTableQueries = (isset($queries['create_table_query'])) ? [$queries['create_table_query']] : [];

            if (!empty($queries['alter_table_queries'])) {
                $relations = array_merge($relations, $createTableQueries);
                $alterTables = array_merge($alterTables, $queries['alter_table_queries']);
                continue;
            }

            $createTables = array_merge($createTables, $createTableQueries);
        }

        return array_merge($createTables, $relations, $alterTables);
    }

    private function fromTableToSQLQueries(Table $table) {

        $createAlterQueries = function($name, array $fields) {
            $alterQueries = [];
            foreach($fields as $oneField) {

                if (!$oneField->hasForeignKey()) {
                    continue;
                }

                $foreignKey = $oneField->getForeignKey();
                if (!$foreignKey->hasTableReference()) {
                    continue;
                }

                $tableReference = $foreignKey->getTableReference();
                if (!$tableReference->hasPrimaryKey()) {
                    throw new TableException('At least one Field object contains is a foreign key that contains a Table reference, which does NOT have a primary key.');
                }

                $pk = $tableReference->getPrimaryKey();
                $tableReferenceName = $tableReference->getName();
                $tableReferencePrimaryKeyName = $pk->getName();

                $fieldName = $oneField->getName();
                $alterQueries[] = 'alter table '.$name.' add foreign key ('.$fieldName.') references '.$tableReferenceName.'('.$tableReferencePrimaryKeyName.');';

            }

            return $alterQueries;
        };

        try {

            $name = $table->getName();
            $engine = $table->getEngine();
            $fields = $table->getFields();
            $fieldQueryLines = $this->fieldAdapter->fromFieldsToSQLQueryLines($fields);

            $query = 'create table '.$name.' ('.implode(', ', $fieldQueryLines).') Engine='.$engine.';';
            $alterQueries = $createAlterQueries($name, $fields);

            return [
                'create_table_query' => $query,
                'alter_table_queries' => $alterQueries
            ];

        } catch (FieldException $exception) {
            throw new TableException('There was an exception while converting Field objects to sql query lines, or when converting data to sql queries.', $exception);
        }
    }

}
