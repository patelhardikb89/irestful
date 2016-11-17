<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Adapters\Factories\SchemaAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters\PDOSchemaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters\PDOTableAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters\PDOTableFieldAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters\PDOTableFieldTypeAdapter;

final class PDOSchemaAdapterFactory implements SchemaAdapterFactory {
    private $tableDelimiter;
    public function __construct($tableDelimiter) {
        $this->tableDelimiter = $tableDelimiter;
    }

    public function create() {
        $typeAdapter = new PDOTableFieldTypeAdapter();
        $fieldAdapter = new PDOTableFieldAdapter($typeAdapter, $this->tableDelimiter);
        $tableAdapter = new PDOTableAdapter($fieldAdapter);
        return new PDOSchemaAdapter($tableAdapter);
    }

}
