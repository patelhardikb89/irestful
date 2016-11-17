<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters\PDOTableAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Helpers\Adapters\FieldAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\FieldHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\TableHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ForeignKeyHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;

final class PDOTableAdapterTest extends \PHPUnit_Framework_TestCase {
    private $fieldAdapterMock;
    private $fieldMock;
    private $tableMock;
    private $foreignKeyMock;
    private $name;
    private $fieldName;
    private $engine;
    private $referenceTableName;
    private $referenceFieldName;
    private $fields;
    private $fieldQueryLines;
    private $alterQueries;
    private $queries;
    private $queriesWithAlterTables;
    private $queriesWithAll;
    private $adapter;
    private $fieldAdapterHelper;
    private $fieldHelper;
    private $tableHelper;
    private $foreignKeyHelper;
    public function setUp() {
        $this->fieldAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Fields\Adapters\FieldAdapter');
        $this->fieldMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field');
        $this->tableMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table');
        $this->foreignKeyMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\ForeignKey');

        $this->name = 'roles';
        $this->fieldName = 'permission';
        $this->engine = 'innodb';
        $this->referenceTableName = 'permissions';
        $this->referenceFieldName = 'uuid';

        $this->fields = [
            $this->fieldMock,
            $this->fieldMock,
            $this->fieldMock
        ];

        $this->fieldQueryLines = [
            'uuid binary(16) primary key',
            'created_on int(11)'
        ];

        $this->alterQueries = [
            'alter table '.$this->name.' add foreign key ('.$this->fieldName.') references '.$this->referenceTableName.'('.$this->referenceFieldName.');'
        ];

        $this->queries = [
            'create table '.$this->name.' (uuid binary(16) primary key, created_on int(11)) Engine='.$this->engine.';'
        ];

        $this->queriesWithAlterTables = [
            $this->queries[0],
            $this->alterQueries[0]
        ];

        $this->queriesWithAll = [
            $this->queries[0],
            $this->alterQueries[0]
        ];

        $this->adapter = new PDOTableAdapter($this->fieldAdapterMock);

        $this->fieldAdapterHelper = new FieldAdapterHelper($this, $this->fieldAdapterMock);
        $this->fieldHelper = new FieldHelper($this, $this->fieldMock);
        $this->tableHelper = new TableHelper($this, $this->tableMock);
        $this->foreignKeyHelper = new ForeignKeyHelper($this, $this->foreignKeyMock);
    }

    public function tearDown() {

    }

    public function testFromTablesToSQLQueries_Success() {
        
        $this->tableHelper->expectsGetName_multiple_Success([$this->name, $this->referenceTableName]);
        $this->tableHelper->expectsGetEngine_Success($this->engine);
        $this->tableHelper->expectsGetFields_Success($this->fields);
        $this->fieldAdapterHelper->expectsFromFieldsToSQLQueryLines_Success($this->fieldQueryLines, $this->fields);

        $this->fieldHelper->expectsHasForeignKey_multiple_Success([false, true, true]);
        $this->fieldHelper->expectsGetForeignKey_multiple_Success([$this->foreignKeyMock, $this->foreignKeyMock]);
        $this->foreignKeyHelper->expectsHasTableReference_multiple_Success([false, true]);
        $this->foreignKeyHelper->expectsGetTableReference_Success($this->tableMock);
        $this->tableHelper->expectsHasPrimaryKey_Success(true);
        $this->tableHelper->expectsGetPrimaryKey_Success($this->fieldMock);
        $this->fieldHelper->expectsGetName_multiple_Success([$this->referenceFieldName, $this->fieldName]);

        $queries = $this->adapter->fromTablesToSQLQueries([$this->tableMock]);

        $this->assertEquals($this->queriesWithAll, $queries);

    }

}
