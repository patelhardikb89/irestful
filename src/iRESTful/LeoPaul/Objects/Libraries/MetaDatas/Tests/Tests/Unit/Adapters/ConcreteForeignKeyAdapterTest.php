<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteForeignKeyAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\TableAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ArgumentMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ClassMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ArrayMetaDataHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\Exceptions\ForeignKeyException;

final class ConcreteForeignKeyAdapterTest extends \PHPUnit_Framework_TestCase {
    private $tableAdapterMock;
    private $tableMock;
    private $argumentMetaDataMock;
    private $classMetaDataMock;
    private $arrayMetaDataMock;
    private $containerName;
    private $elementsType;
    private $data;
    private $adapter;
    private $tableAdapterHelper;
    private $argumentMetaDataHelper;
    private $classMetaDataHelper;
    private $arrayMetaDataHelper;
    public function setUp() {
        $this->tableAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Adapters\TableAdapter');
        $this->tableMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table');
        $this->argumentMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\ArgumentMetaData');
        $this->classMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData');
        $this->arrayMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData');

        $this->containerName = 'my_container';
        $this->elementsType = 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters\ConcreteForeignKeyAdapterTest';

        $this->data = [
            'argument_metadata' => $this->argumentMetaDataMock,
            'parent_class_metadata' => $this->classMetaDataMock,
        ];

        $this->adapter = new ConcreteForeignKeyAdapter($this->tableAdapterMock);

        $this->tableAdapterHelper = new TableAdapterHelper($this, $this->tableAdapterMock);
        $this->argumentMetaDataHelper = new ArgumentMetaDataHelper($this, $this->argumentMetaDataMock);
        $this->classMetaDataHelper = new ClassMetaDataHelper($this, $this->classMetaDataMock);
        $this->arrayMetaDataHelper = new ArrayMetaDataHelper($this, $this->arrayMetaDataMock);
    }

    public function tearDown() {

    }

    public function testFromDataToForeignKey_withClassMetaData_Success() {

        $this->argumentMetaDataHelper->expectsHasClassMetaData_Success(true);
        $this->argumentMetaDataHelper->expectsGetClassMetaData_Success($this->classMetaDataMock);
        $this->classMetaDataHelper->expectsHasContainerName_Success(true);
        $this->classMetaDataHelper->expectsGetContainerName_Success($this->containerName);
        $this->tableAdapterHelper->expectsFromDataToTable_Success($this->tableMock, ['container' => $this->containerName]);

        $foreignKey = $this->adapter->fromDataToForeignKey($this->data);

        $this->assertTrue($foreignKey->hasTableReference());
        $this->assertEquals($this->tableMock, $foreignKey->getTableReference());
        $this->assertFalse($foreignKey->hasMultiTableReference());
        $this->assertNull($foreignKey->getMultiTableReference());


    }

    public function testFromDataToForeignKey_withClassMetaData_withoutContainerName_Success() {

        $this->argumentMetaDataHelper->expectsHasClassMetaData_Success(true);
        $this->argumentMetaDataHelper->expectsGetClassMetaData_Success($this->classMetaDataMock);
        $this->classMetaDataHelper->expectsHasContainerName_Success(false);

        $foreignKey = $this->adapter->fromDataToForeignKey($this->data);

        $this->assertNull($foreignKey);
    }

    public function testFromDataToForeignKey_isRecursive_Success() {

        $this->argumentMetaDataHelper->expectsHasClassMetaData_Success(false);
        $this->argumentMetaDataHelper->expectsIsRecursive_Success(true);
        $this->tableAdapterHelper->expectsFromClassMetaDataToTable_Success($this->tableMock, $this->classMetaDataMock);

        $foreignKey = $this->adapter->fromDataToForeignKey($this->data);

        $this->assertTrue($foreignKey->hasTableReference());
        $this->assertEquals($this->tableMock, $foreignKey->getTableReference());
        $this->assertFalse($foreignKey->hasMultiTableReference());
        $this->assertNull($foreignKey->getMultiTableReference());


    }

    public function testFromDataToForeignKey_withoutClassMetaData_isNotRecursive_withoutArrayMetaData_Success() {

        $this->argumentMetaDataHelper->expectsHasClassMetaData_Success(false);
        $this->argumentMetaDataHelper->expectsIsRecursive_Success(false);

        $foreignKey = $this->adapter->fromDataToForeignKey($this->data);

        $this->assertNull($foreignKey);
    }

    public function testFromDataToForeignKey_withClassMetaData_throwsTableException_throwsForeignKeyException() {

        $this->argumentMetaDataHelper->expectsHasClassMetaData_Success(true);
        $this->argumentMetaDataHelper->expectsGetClassMetaData_Success($this->classMetaDataMock);
        $this->classMetaDataHelper->expectsHasContainerName_Success(true);
        $this->classMetaDataHelper->expectsGetContainerName_Success($this->containerName);
        $this->tableAdapterHelper->expectsFromDataToTable_throwsTableException(['container' => $this->containerName]);

        $asserted = false;
        try {

            $this->adapter->fromDataToForeignKey($this->data);

        } catch (ForeignKeyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);


    }

    public function testFromDataToForeignKey_withoutArgumentMetaData_throwsForeignKeyException() {

        unset($this->data['argument_metadata']);

        $asserted = false;
        try {

            $this->adapter->fromDataToForeignKey($this->data);

        } catch (ForeignKeyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);


    }

    public function testFromDataToForeignKey_withoutParentClassMetaData_throwsForeignKeyException() {

        unset($this->data['parent_class_metadata']);

        $asserted = false;
        try {

            $this->adapter->fromDataToForeignKey($this->data);

        } catch (ForeignKeyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);


    }

}
