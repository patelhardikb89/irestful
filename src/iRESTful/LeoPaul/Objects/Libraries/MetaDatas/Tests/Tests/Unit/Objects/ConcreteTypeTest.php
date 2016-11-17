<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeTest extends \PHPUnit_Framework_TestCase {
    private $binaryMock;
    private $floatMock;
    private $integerMock;
    private $stringMock;
    public function setUp() {
        $this->binaryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Binaries\BinaryType');
        $this->floatMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Floats\FloatType');
        $this->integerMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Integers\IntegerType');
        $this->stringMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Strings\StringType');
    }

    public function tearDown() {

    }

    public function testCreate_withBinary_Success() {

        $type = new ConcreteType($this->binaryMock);

        $this->assertTrue($type->hasBinary());
        $this->assertEquals($this->binaryMock, $type->getBinary());
        $this->assertFalse($type->hasFloat());
        $this->assertNull($type->getFloat());
        $this->assertFalse($type->hasInteger());
        $this->assertNull($type->getInteger());
        $this->assertFalse($type->hasString());
        $this->assertNull($type->getString());

    }

    public function testCreate_withFloat_Success() {

        $type = new ConcreteType(null, $this->floatMock);

        $this->assertFalse($type->hasBinary());
        $this->assertNull($type->getBinary());
        $this->assertTrue($type->hasFloat());
        $this->assertEquals($this->floatMock, $type->getFloat());
        $this->assertFalse($type->hasInteger());
        $this->assertNull($type->getInteger());
        $this->assertFalse($type->hasString());
        $this->assertNull($type->getString());

    }

    public function testCreate_withInteger_Success() {

        $type = new ConcreteType(null, null, $this->integerMock);

        $this->assertFalse($type->hasBinary());
        $this->assertNull($type->getBinary());
        $this->assertFalse($type->hasFloat());
        $this->assertNull($type->getFloat());
        $this->assertTrue($type->hasInteger());
        $this->assertEquals($this->integerMock, $type->getInteger());
        $this->assertFalse($type->hasString());
        $this->assertNull($type->getString());

    }

    public function testCreate_withString_Success() {

        $type = new ConcreteType(null, null, null, $this->stringMock);

        $this->assertFalse($type->hasBinary());
        $this->assertNull($type->getBinary());
        $this->assertFalse($type->hasFloat());
        $this->assertNull($type->getFloat());
        $this->assertFalse($type->hasInteger());
        $this->assertNull($type->getInteger());
        $this->assertTrue($type->hasString());
        $this->assertEquals($this->stringMock, $type->getString());

    }

    public function testCreate_withTooManyTypes_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteType($this->binaryMock, $this->floatMock, $this->integerMock, $this->stringMock);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withoutType_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteType();

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
