<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteObjectAdapter;
use iRESTful\Rodson\Tests\Inputs\Helpers\Adapters\PropertyAdapterHelper;
use iRESTful\Rodson\Domain\Inputs\Objects\Exceptions\ObjectException;

final class ConcreteObjectAdapterTest extends \PHPUnit_Framework_TestCase {
    private $methodAdapterMock;
    private $propertyAdapterMock;
    private $propertyMock;
    private $databaseMock;
    private $name;
    private $databases;
    private $properties;
    private $data;
    private $dataWithDatabase;
    private $multipleData;
    private $adapter;
    private $propertyAdapterHelper;
    public function setUp() {
        $this->methodAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Methods\Adapters\MethodAdapter');
        $this->propertyAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Properties\Adapters\PropertyAdapter');
        $this->propertyMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property');
        $this->databaseMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Databases\Database');

        $this->name = 'my_object';

        $this->databases = [
            'my_database' => $this->databaseMock
        ];

        $this->properties = [
            $this->propertyMock,
            $this->propertyMock
        ];

        $this->data = [
            'name' => $this->name,
            'properties' => [
                'some' => 'data'
            ]
        ];

        $this->dataWithDatabase = [
            'name' => $this->name,
            'database' => 'my_database',
            'properties' => [
                'some' => 'data'
            ]
        ];

        $this->multipleData = [
            $this->name => [
                'properties' => [
                    'some' => 'data'
                ]
            ]
        ];

        $this->adapter = new ConcreteObjectAdapter($this->methodAdapterMock, $this->propertyAdapterMock, $this->databases);

        $this->propertyAdapterHelper = new PropertyAdapterHelper($this, $this->propertyAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToObject_Success() {

        $this->propertyAdapterHelper->expectsFromDataToProperties_Success($this->properties, $this->data['properties']);

        $object = $this->adapter->fromDataToObject($this->data);

        $this->assertEquals($this->name, $object->getName());
        $this->assertEquals($this->properties, $object->getProperties());
        $this->assertFalse($object->hasDatabase());
        $this->assertNull($object->getDatabase());

    }

    public function testFromDataToObject_withDatabase_Success() {

        $this->propertyAdapterHelper->expectsFromDataToProperties_Success($this->properties, $this->dataWithDatabase['properties']);

        $object = $this->adapter->fromDataToObject($this->dataWithDatabase);

        $this->assertEquals($this->name, $object->getName());
        $this->assertEquals($this->properties, $object->getProperties());
        $this->assertTrue($object->hasDatabase());
        $this->assertEquals($this->databaseMock, $object->getDatabase());

    }

    public function testFromDataToObject_throwsPropertyException_throwsObjectException() {

        $this->propertyAdapterHelper->expectsFromDataToProperties_throwsPropertyException($this->data['properties']);

        $asserted = false;
        try {

            $this->adapter->fromDataToObject($this->data);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToObject_withDatabase_databaseNotFound_throwsObjectException() {

        $this->dataWithDatabase['database'] = 'not_found_database';

        $asserted = false;
        try {

            $this->adapter->fromDataToObject($this->dataWithDatabase);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToObject_withoutProperties_throwsObjectException() {

        unset($this->data['properties']);

        $asserted = false;
        try {

            $this->adapter->fromDataToObject($this->data);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToObject_withoutName_throwsObjectException() {

        unset($this->data['name']);

        $asserted = false;
        try {

            $this->adapter->fromDataToObject($this->data);

        } catch (ObjectException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToObjects_Success() {

        $this->propertyAdapterHelper->expectsFromDataToProperties_Success($this->properties, $this->data['properties']);

        $objects = $this->adapter->fromDataToObjects($this->multipleData);

        $this->assertEquals($this->name, $objects[$this->name]->getName());
        $this->assertEquals($this->properties, $objects[$this->name]->getProperties());
        $this->assertFalse($objects[$this->name]->hasDatabase());
        $this->assertNull($objects[$this->name]->getDatabase());

    }

}
