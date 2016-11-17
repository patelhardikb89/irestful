<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters\PDOSchemaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Helpers\Adapters\TableAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\SchemaHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Exceptions\SchemaException;

final class PDOSchemaAdapterTest extends \PHPUnit_Framework_TestCase {
    private $tableAdapterMock;
    private $tableMock;
    private $schemaMock;
    private $name;
    private $tables;
    private $tableQueries;
    private $queries;
    private $queriesWithTableQueries;
    private $adapter;
    private $tableAdapterHelper;
    private $schemaHelper;
    public function setUp() {
        $this->tableAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Adapters\TableAdapter');
        $this->tableMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table');
        $this->schemaMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Schema');

        $this->name = 'my_db';

        $this->tables = [
            $this->tableMock,
            $this->tableMock
        ];

        $this->tableQueries = [
            'first table query;',
            'second table query;'
        ];

        $this->queries = [
            'drop database if exists '.$this->name.';',
            'create database if not exists '.$this->name.';',
            'use my_db;'
        ];

        $this->queriesWithTableQueries = [
            'drop database if exists '.$this->name.';',
            'create database if not exists '.$this->name.';',
            'use my_db;',
            'first table query;',
            'second table query;'
        ];

        $this->adapter = new PDOSchemaAdapter($this->tableAdapterMock);

        $this->tableAdapterHelper = new TableAdapterHelper($this, $this->tableAdapterMock);
        $this->schemaHelper = new SchemaHelper($this, $this->schemaMock);
    }

    public function tearDown() {

    }

    public function testFromSchemaToSQLQueries_Success() {

        $this->schemaHelper->expectsGetName_Success($this->name);
        $this->schemaHelper->expectsHasTables_Success(false);

        $queries = $this->adapter->fromSchemaToSQLQueries($this->schemaMock);

        $this->assertEquals($this->queries, $queries);
    }

    public function testFromSchemaToSQLQueries_withTables_Success() {

        $this->schemaHelper->expectsGetName_Success($this->name);
        $this->schemaHelper->expectsHasTables_Success(true);
        $this->schemaHelper->expectsGetTables_Success($this->tables);
        $this->tableAdapterHelper->expectsFromTablesToSQLQueries_Success($this->tableQueries, $this->tables);

        $queries = $this->adapter->fromSchemaToSQLQueries($this->schemaMock);

        $this->assertEquals($this->queriesWithTableQueries, $queries);
    }

    public function testFromSchemaToSQLQueries_withTables_throwsTableException_throwsSchemaException() {

        $this->schemaHelper->expectsGetName_Success($this->name);
        $this->schemaHelper->expectsHasTables_Success(true);
        $this->schemaHelper->expectsGetTables_Success($this->tables);
        $this->tableAdapterHelper->expectsFromTablesToSQLQueries_throwsTableException($this->tables);

        $asserted = false;
        try {

            $this->adapter->fromSchemaToSQLQueries($this->schemaMock);

        } catch (SchemaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
