<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteTableAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Repositories\ClassMetaDataRepositoryHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ClassMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\FieldAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\FieldHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\TypeHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;

final class ConcreteTableAdapterTest extends \PHPUnit_Framework_TestCase {
    private $classMetaDataRepositoryMock;
    private $classMetaDataMock;
    private $constructorMetaDataMock;
    private $fieldAdapterMock;
    private $fieldMock;
    private $typeMock;
    private $engine;
    private $delimiter;
    private $containerName;
    private $data;
    private $arguments;
    private $argumentsData;
    private $fields;
    private $adapter;
    private $classMetaDataRepositoryHelper;
    private $classMetaDataHelper;
    private $fieldAdapterHelper;
    private $fieldHelper;
    private $typeHelper;
    public function setUp() {
        $this->classMetaDataRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository');
        $this->classMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData');
        $this->constructorMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData');
        $this->fieldAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Adapters\FieldAdapter');
        $this->fieldMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field');
        $this->typeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type');

        $this->engine = 'innodb';
        $this->delimiter = '___';
        $this->containerName = 'some_container';
        $this->data = [
            'some' => 'data'
        ];

        $this->arguments = [
            $this->constructorMetaDataMock,
            $this->constructorMetaDataMock
        ];

        $this->argumentsData = [
            [
                'parent_class_metadata' => $this->classMetaDataMock,
                'constructor_metadata' => $this->constructorMetaDataMock
            ],
            [
                'parent_class_metadata' => $this->classMetaDataMock,
                'constructor_metadata' => $this->constructorMetaDataMock
            ]
        ];

        $this->fields = [
            $this->fieldMock,
            $this->fieldMock
        ];

        $this->adapter = new ConcreteTableAdapter($this->classMetaDataRepositoryMock, $this->fieldAdapterMock, $this->engine, $this->delimiter);

        $this->classMetaDataRepositoryHelper = new ClassMetaDataRepositoryHelper($this, $this->classMetaDataRepositoryMock);
        $this->classMetaDataHelper = new ClassMetaDataHelper($this, $this->classMetaDataMock);
        $this->fieldAdapterHelper = new FieldAdapterHelper($this, $this->fieldAdapterMock);
        $this->fieldHelper = new FieldHelper($this, $this->fieldMock);
        $this->typeHelper = new TypeHelper($this, $this->typeMock);
    }

    public function tearDown() {

    }

    public function testfromDataToTable_Success() {
        $this->classMetaDataRepositoryHelper->expectsRetrieve_Success($this->classMetaDataMock, $this->data);
        $this->classMetaDataHelper->expectsHasContainerName_Success(true);
        $this->classMetaDataHelper->expectsGetContainerName_Success($this->containerName);
        $this->classMetaDataHelper->expectsGetArguments_Success($this->arguments);
        $this->fieldAdapterHelper->expectsFromDataToFields_Success($this->fields, $this->argumentsData);

        $this->fieldHelper->expectsIsPrimaryKey_Success(true);

        $table = $this->adapter->fromDataToTable($this->data);

        $this->assertEquals($this->containerName, $table->getName());
        $this->assertEquals($this->engine, $table->getEngine());
        $this->assertEquals($this->fieldMock, $table->getPrimaryKey());
        $this->assertEquals($this->fields, $table->getFields());

    }

    public function testfromDataToTable_throwsFieldException_throwsTableException() {
        $this->classMetaDataRepositoryHelper->expectsRetrieve_Success($this->classMetaDataMock, $this->data);
        $this->classMetaDataHelper->expectsHasContainerName_Success(true);
        $this->classMetaDataHelper->expectsGetContainerName_Success($this->containerName);
        $this->classMetaDataHelper->expectsGetArguments_Success($this->arguments);
        $this->fieldAdapterHelper->expectsFromDataToFields_throwsFieldException($this->argumentsData);

        $asserted = false;
        try {

            $this->adapter->fromDataToTable($this->data);

        } catch (TableException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testfromDataToTable_withoutContainerName_throwsTableException() {
        $this->classMetaDataRepositoryHelper->expectsRetrieve_Success($this->classMetaDataMock, $this->data);
        $this->classMetaDataHelper->expectsHasContainerName_Success(false);

        $asserted = false;
        try {

            $this->adapter->fromDataToTable($this->data);

        } catch (TableException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testfromDataToTable_throwsClassMetaDataException_throwsTableException() {
        $this->classMetaDataRepositoryHelper->expectsRetrieve_throwsClassMetaDataException($this->data);

        $asserted = false;
        try {

            $this->adapter->fromDataToTable($this->data);

        } catch (TableException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
