<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeInteger;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeIntegerTest extends \PHPUnit_Framework_TestCase {
    private $maximumBitSize;
    public function setUp() {
        $this->maximumBitSize = rand(1, 500);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $integer = new ConcreteTypeInteger($this->maximumBitSize);

        $this->assertEquals($this->maximumBitSize, $integer->getMaximumBitSize());

    }

    public function testCreate_withStringMaximumBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeInteger('54');

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerMaximumBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeInteger(new \DateTime());

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroMaximumBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeInteger(0);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativeMaximumBitSize_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeInteger($this->maximumBitSize * -1);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
