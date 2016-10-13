<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteObjectProperty;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Exceptions\PropertyException;

final class ConcreteObjectPropertyTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $name;
    public function setUp() {
        $this->typeMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Type');

        $this->name = 'my_property';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $property = new ConcreteObjectProperty($this->name, $this->typeMock, false, false, false);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertFalse($property->isOptional());
        $this->assertFalse($property->isUnique());
        $this->assertFalse($property->isKey());
        $this->assertFalse($property->hasDefault());
        $this->assertNull($property->getDefault());

    }

    public function testCreate_isOptional_Success() {

        $property = new ConcreteObjectProperty($this->name, $this->typeMock, true, false, false);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertTrue($property->isOptional());
        $this->assertFalse($property->isUnique());
        $this->assertFalse($property->isKey());
        $this->assertFalse($property->hasDefault());
        $this->assertNull($property->getDefault());

    }

    public function testCreate_isUnique_Success() {

        $property = new ConcreteObjectProperty($this->name, $this->typeMock, false, true, false);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertFalse($property->isOptional());
        $this->assertTrue($property->isUnique());
        $this->assertFalse($property->isKey());
        $this->assertFalse($property->hasDefault());
        $this->assertNull($property->getDefault());

    }

    public function testCreate_isKey_Success() {

        $property = new ConcreteObjectProperty($this->name, $this->typeMock, false, false, true);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertFalse($property->isOptional());
        $this->assertFalse($property->isUnique());
        $this->assertTrue($property->isKey());
        $this->assertFalse($property->hasDefault());
        $this->assertNull($property->getDefault());

    }

    public function testCreate_isOptional_isUnique_isKey_Success() {

        $property = new ConcreteObjectProperty($this->name, $this->typeMock, true, true, true);

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertTrue($property->isOptional());
        $this->assertTrue($property->isUnique());
        $this->assertTrue($property->isKey());
        $this->assertFalse($property->hasDefault());
        $this->assertNull($property->getDefault());

    }

    public function testCreate_withDefault_Success() {

        $property = new ConcreteObjectProperty($this->name, $this->typeMock, false, false, false, 'not null');

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertFalse($property->isOptional());
        $this->assertFalse($property->isUnique());
        $this->assertFalse($property->isKey());
        $this->assertTrue($property->hasDefault());
        $this->assertEquals('not null', $property->getDefault());

    }

    public function testCreate_isOptional_isUnique_isKey_withDefault_Success() {

        $property = new ConcreteObjectProperty($this->name, $this->typeMock, true, true, true, 'not null');

        $this->assertEquals($this->name, $property->getName());
        $this->assertEquals($this->typeMock, $property->getType());
        $this->assertTrue($property->isOptional());
        $this->assertTrue($property->isUnique());
        $this->assertTrue($property->isKey());
        $this->assertTrue($property->hasDefault());
        $this->assertEquals('not null', $property->getDefault());

    }

    public function testCreate_withCamelCaseName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteObjectProperty('myProperty', $this->typeMock, true, false, false);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsPropertyException() {

        $asserted = false;
        try {

            new ConcreteObjectProperty('', $this->typeMock, true, false, false);

        } catch (PropertyException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
