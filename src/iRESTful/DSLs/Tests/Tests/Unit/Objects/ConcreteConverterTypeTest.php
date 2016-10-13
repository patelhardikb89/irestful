<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteConverterType;
use iRESTful\DSLs\Domain\Projects\Converters\Types\Exceptions\TypeException;

final class ConcreteConverterTypeTest extends \PHPUnit_Framework_TestCase {
    private $primitiveMock;
    private $typeMock;
    public function setUp() {
        $this->primitiveMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Primitives\Primitive');
        $this->typeMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Types\Type');
    }

    public function tearDown() {

    }

    public function testCreate_withPrimitive_Success() {

        $type = new ConcreteConverterType($this->primitiveMock);

        $this->assertTrue($type->hasPrimitive());
        $this->assertEquals($this->primitiveMock, $type->getPrimitive());
        $this->assertFalse($type->hasType());
        $this->assertNull($type->getType());

    }

    public function testCreate_withType_Success() {

        $type = new ConcreteConverterType(null, $this->typeMock);

        $this->assertFalse($type->hasPrimitive());
        $this->assertNull($type->getPrimitive());
        $this->assertTrue($type->hasType());
        $this->assertEquals($this->typeMock, $type->getType());

    }

    public function testCreate_withoutType_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteConverterType();

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withMultipleTypes_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteConverterType($this->primitiveMock, $this->typeMock);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
