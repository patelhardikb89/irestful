<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteObjectPropertyAdapter;
use iRESTful\Rodson\Domain\Objects\Properties\Exceptions\PropertyException;

final class ConcreteObjectPropertyAdapterTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $types;
    private $name;
    private $data;
    private $adapter;
    public function setUp() {
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Types\Type');

        $this->types = [
            'some_type' => $this->typeMock
        ];

        $this->name = 'my_property';
        $this->data = [
            'name' => $this->name,
            'type' => 'some_type'
        ];

        $this->adapter = new ConcreteObjectPropertyAdapter($this->types);
    }

    public function tearDown() {

    }

    public function testFromDataToProperty_Success() {

        $property = $this->adapter->fromDataToProperty($this->data);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());

    }

    public function testFromDataToProperty_typeNotFound_throwsPropertyException() {

        $this->data['type'] = 'invalid_type';

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

        $properties = $this->adapter->fromDataToProperties([$this->data]);

        $this->assertEquals($this->name, $properties[0]->getName());
        $this->assertEquals($this->typeMock, $properties[0]->getType());

    }

}
