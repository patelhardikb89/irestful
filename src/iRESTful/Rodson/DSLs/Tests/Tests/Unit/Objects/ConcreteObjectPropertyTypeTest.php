<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteObjectPropertyType;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Types\Exceptions\TypeException;

final class ConcreteObjectPropertyTypeTest extends \PHPUnit_Framework_TestCase {
    private $primitiveMock;
    private $typeMock;
    private $objectMock;
    public function setUp() {
        $this->primitiveMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Primitives\Primitive');
        $this->typeMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Types\Type');
        $this->objectMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object');
    }

    public function tearDown() {

    }

    public function testCreate_withPrimitive_Success() {

        $type = new ConcreteObjectPropertyType(false, $this->primitiveMock);

        $this->assertFalse($type->isArray());
        $this->assertTrue($type->hasPrimitive());
        $this->assertEquals($this->primitiveMock, $type->getPrimitive());
        $this->assertFalse($type->hasType());
        $this->assertNull($type->getType());
        $this->assertFalse($type->hasObject());
        $this->assertNull($type->getObject());

    }

    public function testCreate_withPrimitive_isArray_Success() {

        $type = new ConcreteObjectPropertyType(true, $this->primitiveMock);

        $this->assertTrue($type->isArray());
        $this->assertTrue($type->hasPrimitive());
        $this->assertEquals($this->primitiveMock, $type->getPrimitive());
        $this->assertFalse($type->hasType());
        $this->assertNull($type->getType());
        $this->assertFalse($type->hasObject());
        $this->assertNull($type->getObject());

    }

    public function testCreate_withType_Success() {

        $type = new ConcreteObjectPropertyType(false, null, $this->typeMock);

        $this->assertFalse($type->isArray());
        $this->assertFalse($type->hasPrimitive());
        $this->assertNull($type->getPrimitive());
        $this->assertTrue($type->hasType());
        $this->assertEquals($this->typeMock, $type->getType());
        $this->assertFalse($type->hasObject());
        $this->assertNull($type->getObject());

    }

    public function testCreate_withType_isArray_Success() {

        $type = new ConcreteObjectPropertyType(true, null, $this->typeMock);

        $this->assertTrue($type->isArray());
        $this->assertFalse($type->hasPrimitive());
        $this->assertNull($type->getPrimitive());
        $this->assertTrue($type->hasType());
        $this->assertEquals($this->typeMock, $type->getType());
        $this->assertFalse($type->hasObject());
        $this->assertNull($type->getObject());

    }

    public function testCreate_withObject_Success() {

        $type = new ConcreteObjectPropertyType(false, null, null, $this->objectMock);

        $this->assertFalse($type->isArray());
        $this->assertFalse($type->hasPrimitive());
        $this->assertNull($type->getPrimitive());
        $this->assertFalse($type->hasType());
        $this->assertNull($type->getType());
        $this->assertTrue($type->hasObject());
        $this->assertEquals($this->objectMock, $type->getObject());

    }

    public function testCreate_withObject_isArray_Success() {

        $type = new ConcreteObjectPropertyType(true, null, null, $this->objectMock);

        $this->assertTrue($type->isArray());
        $this->assertFalse($type->hasPrimitive());
        $this->assertNull($type->getPrimitive());
        $this->assertFalse($type->hasType());
        $this->assertNull($type->getType());
        $this->assertTrue($type->hasObject());
        $this->assertEquals($this->objectMock, $type->getObject());

    }

    public function testCreate_withoutType_Success() {

        $asserted = false;
        try {

            new ConcreteObjectPropertyType(false);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withMultipleTypes_Success() {

        $asserted = false;
        try {

            new ConcreteObjectPropertyType(false, $this->primitiveMock, $this->typeMock, $this->objectMock);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
