<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteTypeAdapter;
use iRESTful\Rodson\Tests\Helpers\Adapters\DatabaseTypeAdapterHelper;
use iRESTful\Rodson\Tests\Helpers\Adapters\MethodAdapterHelper;
use iRESTful\Rodson\Domain\Inputs\Types\Exceptions\TypeException;

final class ConcreteTypeAdapterTest extends \PHPUnit_Framework_TestCase {
    private $databaseTypeAdapterMock;
    private $databaseTypeMock;
    private $methodAdapterMock;
    private $methodMock;
    private $adapterMock;
    private $name;
    private $databaseTypeData;
    private $data;
    private $dataWithDatabaseAdapter;
    private $dataWithViewAdapter;
    private $dataWithMethod;
    private $dataWithAll;
    private $multipleData;
    private $adapters;
    private $adapter;
    private $databaseTypeAdapterHelper;
    private $methodAdapterHelper;
    public function setUp() {
        $this->databaseTypeAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Types\Databases\Adapters\DatabaseTypeAdapter');
        $this->databaseTypeMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Types\Databases\DatabaseType');
        $this->methodAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Codes\Methods\Adapters\MethodAdapter');
        $this->methodMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Codes\Methods\Method');
        $this->adapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Adapters\Adapter');

        $this->name = 'uri';

        $this->databaseTypeData = [
            'some' => 'db type data'
        ];

        $this->data = [
            'name' => $this->name,
            'database_type' => $this->databaseTypeData
        ];

        $this->multipleData = [
            $this->name => [
                'database_type' => $this->databaseTypeData
            ]
        ];

        $this->dataWithDatabaseAdapter = [
            'name' => $this->name,
            'database_type' => $this->databaseTypeData,
            'adapters' => [
                'database_to_object' => [
                    'from' => 'string',
                    'to' => 'uri'
                ]
            ]
        ];

        $this->dataWithViewAdapter = [
            'name' => $this->name,
            'database_type' => $this->databaseTypeData,
            'adapters' => [
                'object_to_view' => [
                    'from' => 'uri',
                    'to' => 'string'
                ]
            ]
        ];

        $this->dataWithMethod = [
            'name' => $this->name,
            'database_type' => $this->databaseTypeData,
            'method' => 'myMethod'
        ];

        $this->dataWithAll = [
            'name' => $this->name,
            'database_type' => $this->databaseTypeData,
            'method' => 'myMethod',
            'adapters' => [
                'database_to_object' => [
                    'from' => 'string',
                    'to' => 'uri'
                ],
                'object_to_view' => [
                    'from' => 'uri',
                    'to' => 'string'
                ]
            ]
        ];

        $this->adapters = [
            'from_string_to_uri' => $this->adapterMock,
            'from_uri_to_string' => $this->adapterMock
        ];

        $this->adapter = new ConcreteTypeAdapter($this->databaseTypeAdapterMock, $this->methodAdapterMock, $this->adapters);

        $this->databaseTypeAdapterHelper = new DatabaseTypeAdapterHelper($this, $this->databaseTypeAdapterMock);
        $this->methodAdapterHelper = new MethodAdapterHelper($this, $this->methodAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToType_Success() {

        $this->databaseTypeAdapterHelper->expectsFromDataToDatabaseType_Success($this->databaseTypeMock, $this->databaseTypeData);

        $type = $this->adapter->fromDataToType($this->data);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertFalse($type->hasDatabaseAdapter());
        $this->assertNull($type->getDatabaseAdapter());
        $this->assertFalse($type->hasViewAdapter());
        $this->assertNull($type->getViewAdapter());
        $this->assertFalse($type->hasMethod());
        $this->assertNull($type->getMethod());

    }

    public function testFromDataToType_withDatabaseAdapter_Success() {

        $this->databaseTypeAdapterHelper->expectsFromDataToDatabaseType_Success($this->databaseTypeMock, $this->databaseTypeData);

        $type = $this->adapter->fromDataToType($this->dataWithDatabaseAdapter);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertTrue($type->hasDatabaseAdapter());
        $this->assertEquals($this->adapterMock, $type->getDatabaseAdapter());
        $this->assertFalse($type->hasViewAdapter());
        $this->assertNull($type->getViewAdapter());
        $this->assertFalse($type->hasMethod());
        $this->assertNull($type->getMethod());

    }

    public function testFromDataToType_withViewAdapter_Success() {

        $this->databaseTypeAdapterHelper->expectsFromDataToDatabaseType_Success($this->databaseTypeMock, $this->databaseTypeData);

        $type = $this->adapter->fromDataToType($this->dataWithViewAdapter);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertFalse($type->hasDatabaseAdapter());
        $this->assertNull($type->getDatabaseAdapter());
        $this->assertTrue($type->hasViewAdapter());
        $this->assertEquals($this->adapterMock, $type->getViewAdapter());
        $this->assertFalse($type->hasMethod());
        $this->assertNull($type->getMethod());

    }

    public function testFromDataToType_withMethod_Success() {

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->dataWithMethod['method']);
        $this->databaseTypeAdapterHelper->expectsFromDataToDatabaseType_Success($this->databaseTypeMock, $this->databaseTypeData);

        $type = $this->adapter->fromDataToType($this->dataWithMethod);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertFalse($type->hasDatabaseAdapter());
        $this->assertNull($type->getDatabaseAdapter());
        $this->assertFalse($type->hasViewAdapter());
        $this->assertNull($type->getViewAdapter());
        $this->assertTrue($type->hasMethod());
        $this->assertEquals($this->methodMock, $type->getMethod());

    }

    public function testFromDataToType_withDatabaseAdapter_withViewAdapter_withMethod_Success() {

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->dataWithAll['method']);
        $this->databaseTypeAdapterHelper->expectsFromDataToDatabaseType_Success($this->databaseTypeMock, $this->databaseTypeData);

        $type = $this->adapter->fromDataToType($this->dataWithAll);

        $this->assertEquals($this->name, $type->getName());
        $this->assertEquals($this->databaseTypeMock, $type->getDatabaseType());
        $this->assertTrue($type->hasDatabaseAdapter());
        $this->assertEquals($this->adapterMock, $type->getDatabaseAdapter());
        $this->assertTrue($type->hasViewAdapter());
        $this->assertEquals($this->adapterMock, $type->getViewAdapter());
        $this->assertTrue($type->hasMethod());
        $this->assertEquals($this->methodMock, $type->getMethod());

    }

    public function testFromDataToType_throwsDatabaseTypeException_throwsTypeException() {

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->dataWithAll['method']);
        $this->databaseTypeAdapterHelper->expectsFromDataToDatabaseType_throwsDatabaseTypeException($this->databaseTypeData);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithAll);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_throwsMethodException_throwsTypeException() {

        $this->methodAdapterHelper->expectsFromStringToMethod_throwsMethodException($this->dataWithAll['method']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithAll);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_withDatabaseAdapter_notFoundDatabaseAdapter_throwsTypeException() {

        $this->dataWithDatabaseAdapter['adapters']['database_to_object'] = [
            'from' => 'invalid',
            'to' => 'another_invalid'
        ];

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithDatabaseAdapter);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_withDatabaseAdapter_withoutFrom_throwsTypeException() {

        unset($this->dataWithDatabaseAdapter['adapters']['database_to_object']['from']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithDatabaseAdapter);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_withDatabaseAdapter_withoutTo_throwsTypeException() {

        unset($this->dataWithDatabaseAdapter['adapters']['database_to_object']['to']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithDatabaseAdapter);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_withViewAdapter_notFoundViewAdapter_throwsTypeException() {

        $this->dataWithViewAdapter['adapters']['object_to_view'] = [
            'from' => 'invalid',
            'to' => 'another_invalid'
        ];

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithViewAdapter);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_withViewAdapter_withoutFrom_throwsTypeException() {

        unset($this->dataWithViewAdapter['adapters']['object_to_view']['from']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithViewAdapter);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_withViewAdapter_withoutTo_throwsTypeException() {

        unset($this->dataWithViewAdapter['adapters']['object_to_view']['to']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->dataWithViewAdapter);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_withoutName_throwsTypeException() {

        unset($this->data['name']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->data);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToType_withoutDatabaseType_throwsTypeException() {

        unset($this->data['database_type']);

        $asserted = false;
        try {

            $this->adapter->fromDataToType($this->data);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToTypes_Success() {

        $this->databaseTypeAdapterHelper->expectsFromDataToDatabaseType_Success($this->databaseTypeMock, $this->databaseTypeData);

        $types = $this->adapter->fromDataToTypes($this->multipleData);

        $this->assertEquals($this->name, $types[$this->name]->getName());
        $this->assertEquals($this->databaseTypeMock, $types[$this->name]->getDatabaseType());
        $this->assertFalse($types[$this->name]->hasDatabaseAdapter());
        $this->assertNull($types[$this->name]->getDatabaseAdapter());
        $this->assertFalse($types[$this->name]->hasViewAdapter());
        $this->assertNull($types[$this->name]->getViewAdapter());
        $this->assertFalse($types[$this->name]->hasMethod());
        $this->assertNull($types[$this->name]->getMethod());
    }

}
