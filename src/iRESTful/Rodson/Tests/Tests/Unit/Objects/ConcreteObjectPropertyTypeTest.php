<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteObjectPropertyType;
use iRESTful\Rodson\Domain\Objects\Properties\Types\Exceptions\TypeException;

final class ConcreteObjectPropertyTypeTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $objectMock;
    public function setUp() {
        $this->typeMock = $this->getMock('iRESTful\Rodson\Domain\Types\Type');
        $this->objectMock = $this->getMock('iRESTful\Rodson\Domain\Objects\Object');
    }

    public function tearDown() {

    }

    public function testCreate_withType_Success() {

        $type = new ConcreteObjectPropertyType(false, $this->typeMock);

        $this->assertFalse($type->isArray());
        $this->assertTrue($type->hasType());
        $this->assertEquals($this->typeMock, $type->getType());
        $this->assertFalse($type->hasObject());
        $this->assertNull($type->getObject());

    }

    public function testCreate_withType_isArray_Success() {

        $type = new ConcreteObjectPropertyType(true, $this->typeMock);

        $this->assertTrue($type->isArray());
        $this->assertTrue($type->hasType());
        $this->assertEquals($this->typeMock, $type->getType());
        $this->assertFalse($type->hasObject());
        $this->assertNull($type->getObject());

    }

    public function testCreate_withObject_Success() {

        $type = new ConcreteObjectPropertyType(false, null, $this->objectMock);

        $this->assertFalse($type->isArray());
        $this->assertFalse($type->hasType());
        $this->assertNull($type->getType());
        $this->assertTrue($type->hasObject());
        $this->assertEquals($this->objectMock, $type->getObject());

    }

    public function testCreate_withObject_isArray_Success() {

        $type = new ConcreteObjectPropertyType(true, null, $this->objectMock);

        $this->assertTrue($type->isArray());
        $this->assertFalse($type->hasType());
        $this->assertNull($type->getType());
        $this->assertTrue($type->hasObject());
        $this->assertEquals($this->objectMock, $type->getObject());

    }

    public function testCreate_withoutType_withoutObject_Success() {

        $asserted = false;
        try {

            new ConcreteObjectPropertyType(true);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withType_withObject_Success() {

        $asserted = false;
        try {

            new ConcreteObjectPropertyType(true, $this->typeMock, $this->objectMock);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
