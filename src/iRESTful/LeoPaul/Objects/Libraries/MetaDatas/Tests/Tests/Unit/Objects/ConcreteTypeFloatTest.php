<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeFloat;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeFloatTest extends \PHPUnit_Framework_TestCase {
    private $digitAmount;
    private $precision;
    public function setUp() {
        $this->digitAmount = rand(1, 500);
        $this->precision = rand(1, 400);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $float = new ConcreteTypeFloat($this->digitAmount, $this->precision);

        $this->assertEquals($this->digitAmount, $float->getDigitsAmount());
        $this->assertEquals($this->precision, $float->getPrecision());

    }

    public function testCreate_withNegativeDigitsAmount_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeFloat($this->digitAmount * -1, $this->precision, true);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativePrecision_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeFloat($this->digitAmount, $this->precision * -1, true);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroDigitsAmount_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeFloat(0, $this->precision, true);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroPrecision_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeFloat($this->digitAmount, 0, true);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withStringDigitsAmount_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeFloat('76', $this->precision, true);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withStringPrecision_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeFloat($this->digitAmount, '89', true);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerDigitsAmount_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeFloat(new \DateTime(), $this->precision, true);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerPrecision_throwsTypeException() {

        $asserted = false;
        try {

            new ConcreteTypeFloat($this->digitAmount, new \DateTime(), true);

        } catch (TypeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
