<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcretePrimitive;
use iRESTful\DSLs\Domain\Projects\Primitives\Exceptions\PrimitiveException;

final class ConcretePrimitiveTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {

    }

    public function tearDown() {

    }

    public function testCreate_withString_Success() {

        $primitive = new ConcretePrimitive(true, false, false, false);

        $this->assertTrue($primitive->isString());
        $this->assertFalse($primitive->isBoolean());
        $this->assertFalse($primitive->isInteger());
        $this->assertFalse($primitive->isFloat());

    }

    public function testCreate_witBoolean_Success() {

        $primitive = new ConcretePrimitive(false, true, false, false);

        $this->assertFalse($primitive->isString());
        $this->assertTrue($primitive->isBoolean());
        $this->assertFalse($primitive->isInteger());
        $this->assertFalse($primitive->isFloat());

    }

    public function testCreate_witInteger_Success() {

        $primitive = new ConcretePrimitive(false, false, true, false);

        $this->assertFalse($primitive->isString());
        $this->assertFalse($primitive->isBoolean());
        $this->assertTrue($primitive->isInteger());
        $this->assertFalse($primitive->isFloat());

    }

    public function testCreate_witFloat_Success() {

        $primitive = new ConcretePrimitive(false, false, false, true);

        $this->assertFalse($primitive->isString());
        $this->assertFalse($primitive->isBoolean());
        $this->assertFalse($primitive->isInteger());
        $this->assertTrue($primitive->isFloat());

    }

    public function testCreate_withoutPrimitive_throwsPrimitiveException() {

        $asserted = false;
        try {

            new ConcretePrimitive(false, false, false, false);

        } catch (PrimitiveException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withMultiplePrimitives_throwsPrimitiveException() {

        $asserted = false;
        try {

            new ConcretePrimitive(true, true, true, true);

        } catch (PrimitiveException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
