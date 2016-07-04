<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteObjectAdapter;
use iRESTful\Rodson\Tests\Helpers\Adapters\PropertyAdapterHelper;
use iRESTful\Rodson\Domain\Objects\Exceptions\ObjectException;

final class ConcreteObjectAdapterTest extends \PHPUnit_Framework_TestCase {
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
        $this->propertyAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Objects\Properties\Adapters\PropertyAdapter');
        $this->propertyMock = $this->getMock('iRESTful\Rodson\Domain\Objects\Properties\Property');
        $this->databaseMock = $this->getMock('iRESTful\Rodson\Domain\Databases\Database');

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

        $this->adapter = new ConcreteObjectAdapter($this->propertyAdapterMock, $this->databases);

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

        $this->assertEquals($this->name, $objects[0]->getName());
        $this->assertEquals($this->properties, $objects[0]->getProperties());
        $this->assertFalse($objects[0]->hasDatabase());
        $this->assertNull($objects[0]->getDatabase());

    }

}
