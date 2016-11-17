<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeBinary;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeBinaryTest extends \PHPUnit_Framework_TestCase {
    private $specificBitSize;
    private $maxBitSize;
    public function setUp() {

        $this->specificBitSize = rand(1, 500);
        $this->maxBitSize = rand(1, 500);

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $binary = new ConcreteTypeBinary();

        $this->assertFalse($binary->hasSpecificBitSize());
        $this->assertNull($binary->getSpecificBitSize());
        $this->assertFalse($binary->hasMaxBitSize());
        $this->assertNull($binary->getMaxBitSize());

    }

    public function testCreate_withSpecificBitSize_Success() {

        $binary = new ConcreteTypeBinary($this->specificBitSize);

        $this->assertTrue($binary->hasSpecificBitSize());
        $this->assertEquals($this->specificBitSize, $binary->getSpecificBitSize());
        $this->assertFalse($binary->hasMaxBitSize());
        $this->assertNull($binary->getMaxBitSize());

    }

    public function testCreate_withMaxBitSize_Success() {

        $binary = new ConcreteTypeBinary(null, $this->maxBitSize);

        $this->assertFalse($binary->hasSpecificBitSize());
        $this->assertNull($binary->getSpecificBitSize());
        $this->assertTrue($binary->hasMaxBitSize());
        $this->assertEquals($this->maxBitSize, $binary->getMaxBitSize());

    }

    public function testCreate_withSpecificBitSize_withMaxBitSize_Success() {

        $asserted = false;
        try {

            new ConcreteTypeBinary($this->specificBitSize, $this->maxBitSize);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroSpecificBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeBinary(0);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroMaxBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeBinary(null, 0);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeSpecificBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeBinary($this->specificBitSize * -1);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeZeroMaxBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeBinary(null, $this->maxBitSize * -1);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withStringSpecificBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeBinary('9');

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withStringZeroMaxBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeBinary(null, '8');

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerSpecificBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeBinary(new \DateTime());

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerZeroMaxBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeBinary(null, new \DateTime());

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
