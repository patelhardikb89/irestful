<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters\PDOTableFieldAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Helpers\Adapters\TypeAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\FieldHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Exceptions\FieldException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\TableHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ForeignKeyHelper;

final class PDOTableFieldAdapterTest extends \PHPUnit_Framework_TestCase {
    private $typeAdapterMock;
    private $typeMock;
    private $fieldMock;
    private $tableMock;
    private $foreignKeyMock;
    private $tableDelimiter;
    private $fieldName;
    private $default;
    private $typeInSqlQuery;
    private $query;
    private $queryWithNotNull;
    private $queryWithDefault;
    private $queryWithNonNullDefault;
    private $queryWithPrimaryKey;
    private $queryWithNonNullWithDefault;
    private $tableName;
    private $tableEngine;
    private $primaryKeyTypeInSQLQueryLine;
    private $referencedTableName;
    private $referencedFieldName;
    private $fields;
    private $data;
    private $queries;
    private $adapter;
    private $typeAdapterHelper;
    private $fieldHelper;
    private $tableHelper;
    private $foreignKeyHelper;
    public function setUp() {
        $this->typeAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Fields\Types\Adapters\TypeAdapter');
        $this->typeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type');
        $this->fieldMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field');
        $this->tableMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table');
        $this->foreignKeyMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\ForeignKey');

        $this->tableDelimiter = '___';
        $this->fieldName = 'my_field';
        $this->default = 'my_string';

        $this->tableName = 'my_table';
        $this->tableEngine = 'innodb';
        $this->primaryKeyTypeInSQLQueryLine = 'binary(16)';
        $this->referencedTableName = 'referenced_table';
        $this->referencedFieldName = 'referenced_field';

        $this->typeInSqlQuery = 'binary(16)';
        $this->query = $this->fieldName.' '.$this->typeInSqlQuery;
        $this->queryWithNotNull = $this->query.' not null';
        $this->queryWithDefault = $this->query.' default null';
        $this->queryWithNonNullDefault = $this->query." default '".$this->default."'";
        $this->queryWithPrimaryKey = $this->query.' primary key';
        $this->queryWithNonNullWithDefault = $this->queryWithNotNull." default '".$this->default."'";

        $this->fields = [
            $this->fieldMock,
            $this->fieldMock,
            $this->fieldMock
        ];

        $this->data = [
            'parent_table' => $this->tableMock,
            'fields' => $this->fields
        ];

        $this->queries = [
            'create table my_table___my_field (master_uuid binary(16), slave_uuid binary(16)) Engine=innodb;',
            'alter table my_table___my_field add foreign key (master_uuid) references referenced_table(referenced_field);'
        ];

        $this->adapter = new PDOTableFieldAdapter($this->typeAdapterMock, $this->tableDelimiter);

        $this->typeAdapterHelper = new TypeAdapterHelper($this, $this->typeAdapterMock);
        $this->fieldHelper = new FieldHelper($this, $this->fieldMock);
        $this->tableHelper = new TableHelper($this, $this->tableMock);
        $this->foreignKeyHelper = new ForeignKeyHelper($this, $this->foreignKeyMock);

    }

    public function tearDown() {

    }

    public function testFromFieldToSQLQueryLine_Success() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(false);
        $this->fieldHelper->expectsHasDefault_Success(false);
        $this->fieldHelper->expectsIsPrimaryKey_Success(false);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);

        $query = $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        $this->assertEquals($this->queryWithNotNull, $query);

    }

    public function testFromFieldToSQLQueryLine_isNullable_Success() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(true);
        $this->fieldHelper->expectsHasDefault_Success(false);
        $this->fieldHelper->expectsIsPrimaryKey_Success(false);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);

        $query = $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        $this->assertEquals($this->query, $query);

    }

    public function testFromFieldToSQLQueryLine_hasDefault_Success() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(false);
        $this->fieldHelper->expectsHasDefault_Success(true);
        $this->fieldHelper->expectsIsPrimaryKey_Success(false);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);
        $this->fieldHelper->expectsGetDefault_Success($this->default);

        $query = $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        $this->assertEquals($this->queryWithNonNullWithDefault, $query);

    }

    public function testFromFieldToSQLQueryLine_isNullable_hasDefault_Success() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(true);
        $this->fieldHelper->expectsHasDefault_Success(true);
        $this->fieldHelper->expectsIsPrimaryKey_Success(false);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);
        $this->fieldHelper->expectsGetDefault_Success($this->default);

        $query = $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        $this->assertEquals($this->queryWithNonNullDefault, $query);

    }

    public function testFromFieldToSQLQueryLine_isNullable_hasNullDefault_Success() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(true);
        $this->fieldHelper->expectsHasDefault_Success(true);
        $this->fieldHelper->expectsIsPrimaryKey_Success(false);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);
        $this->fieldHelper->expectsGetDefault_Success('null');

        $query = $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        $this->assertEquals($this->queryWithDefault, $query);

    }

    public function testFromFieldToSQLQueryLine_isNotNullable_hasNullDefault_throwsFieldException() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(false);
        $this->fieldHelper->expectsHasDefault_Success(true);
        $this->fieldHelper->expectsIsPrimaryKey_Success(false);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);
        $this->fieldHelper->expectsGetDefault_Success('null');

        $asserted = false;
        try {

            $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromFieldToSQLQueryLine_hasPrimaryKey_throwsFieldException() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(false);
        $this->fieldHelper->expectsHasDefault_Success(false);
        $this->fieldHelper->expectsIsPrimaryKey_Success(true);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);

        $query = $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        $this->assertEquals($this->queryWithPrimaryKey, $query);

    }

    public function testFromFieldToSQLQueryLine_hasPrimaryKey_isNullable_throwsFieldException() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(true);
        $this->fieldHelper->expectsHasDefault_Success(false);
        $this->fieldHelper->expectsIsPrimaryKey_Success(true);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);

        $asserted = false;
        try {

            $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromFieldToSQLQueryLine_hasPrimaryKey_isHasDefault_throwsFieldException() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(false);
        $this->fieldHelper->expectsHasDefault_Success(true);
        $this->fieldHelper->expectsIsPrimaryKey_Success(true);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);
        $this->fieldHelper->expectsGetDefault_Success($this->default);

        $asserted = false;
        try {

            $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromFieldToSQLQueryLine_hasPrimaryKey_isNullable_isHasDefault_throwsFieldException() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(true);
        $this->fieldHelper->expectsHasDefault_Success(true);
        $this->fieldHelper->expectsIsPrimaryKey_Success(true);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);
        $this->fieldHelper->expectsGetDefault_Success($this->default);

        $asserted = false;
        try {

            $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromFieldToSQLQueryLine_throwsTypeException_throwsFieldException() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(false);
        $this->fieldHelper->expectsHasDefault_Success(false);
        $this->fieldHelper->expectsIsPrimaryKey_Success(false);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_throwsTypeException($this->typeMock);

        $asserted = false;
        try {

            $this->adapter->fromFieldToSQLQueryLine($this->fieldMock);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromFieldsToSQLQueryLines_Success() {

        $this->fieldHelper->expectsGetName_Success($this->fieldName);
        $this->fieldHelper->expectsGetType_Success($this->typeMock);
        $this->fieldHelper->expectsIsNullable_Success(false);
        $this->fieldHelper->expectsHasDefault_Success(false);
        $this->fieldHelper->expectsIsPrimaryKey_Success(false);

        $this->typeAdapterHelper->expectsFromTypeToTypeInSqlQueryLine_Success($this->typeInSqlQuery, $this->typeMock);

        $queries = $this->adapter->fromFieldsToSQLQueryLines([$this->fieldMock]);

        $this->assertEquals([$this->queryWithNotNull], $queries);

    }

}
