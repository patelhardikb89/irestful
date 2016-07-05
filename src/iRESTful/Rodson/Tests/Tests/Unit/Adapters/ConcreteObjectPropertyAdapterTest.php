<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteObjectPropertyAdapter;
use iRESTful\Rodson\Domain\Objects\Properties\Exceptions\PropertyException;
use iRESTful\Rodson\Tests\Helpers\Adapters\PropertyTypeAdapterHelper;

final class ConcreteObjectPropertyAdapterTest extends \PHPUnit_Framework_TestCase {
    private $typeAdapterMock;
    private $typeMock;
    private $types;
    private $name;
    private $type;
    private $data;
    private $adapter;
    private $typeAdapterHelper;
    public function setUp() {
        $this->typeAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Objects\Properties\Types\Adapters\TypeAdapter');
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Objects\Properties\Types\Type');

        $this->name = 'my_property';
        $this->type = 'some_type';

        $this->data = [
            'name' => $this->name,
            'type' => $this->type
        ];

        $this->adapter = new ConcreteObjectPropertyAdapter($this->typeAdapterMock);

        $this->typeAdapterHelper = new PropertyTypeAdapterHelper($this, $this->typeAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToProperty_Success() {

        $this->typeAdapterHelper->expectsFromStringToType_Success($this->typeMock, $this->type);

        $property = $this->adapter->fromDataToProperty($this->data);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertFalse($property->isOptional());

    }

    public function testFromDataToProperty_isNotOptional_Success() {

        $this->data['is_optional'] = false;

        $this->typeAdapterHelper->expectsFromStringToType_Success($this->typeMock, $this->type);

        $property = $this->adapter->fromDataToProperty($this->data);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertFalse($property->isOptional());

    }

    public function testFromDataToProperty_isOptional_Success() {

        $this->data['is_optional'] = true;

        $this->typeAdapterHelper->expectsFromStringToType_Success($this->typeMock, $this->type);

        $property = $this->adapter->fromDataToProperty($this->data);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertTrue($property->isOptional());

    }

    public function testFromDataToProperty_throwsTypeException_throwsPropertyException() {

        $this->typeAdapterHelper->expectsFromStringToType_throwsTypeException($this->type);

        $asserted = false;
        try {

            $this->adapter->fromDataToProperty($this->data);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToProperty_withoutName_throwsPropertyException() {

        unset($this->data['name']);

        $asserted = false;
        try {

            $this->adapter->fromDataToProperty($this->data);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToProperty_withoutType_throwsPropertyException() {

        unset($this->data['type']);

        $asserted = false;
        try {

            $this->adapter->fromDataToProperty($this->data);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToProperties_Success() {

        $this->typeAdapterHelper->expectsFromStringToType_Success($this->typeMock, $this->type);

        $properties = $this->adapter->fromDataToProperties([
            $this->name => $this->type
        ]);

        $this->assertEquals($this->name, $properties[0]->getName());
        $this->assertEquals($this->typeMock, $properties[0]->getType());
        $this->assertFalse($properties[0]->isOptional());

    }

    public function testFromDataToProperties_isOptional_Success() {

        $this->typeAdapterHelper->expectsFromStringToType_Success($this->typeMock, $this->type);

        $properties = $this->adapter->fromDataToProperties([
            $this->name.'?' => $this->type
        ]);

        $this->assertEquals($this->name, $properties[0]->getName());
        $this->assertEquals($this->typeMock, $properties[0]->getType());
        $this->assertTrue($properties[0]->isOptional());

    }

}
