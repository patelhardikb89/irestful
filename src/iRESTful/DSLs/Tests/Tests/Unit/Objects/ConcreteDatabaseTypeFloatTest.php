<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteDatabaseTypeFloat;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Floats\Exceptions\FloatException;

final class ConcreteDatabaseTypeFloatTest extends \PHPUnit_Framework_TestCase {
    private $digitAmount;
    private $precision;
    public function setUp() {
        $this->digitAmount = rand(1, 500);
        $this->precision = rand(1, 400);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $float = new ConcreteDatabaseTypeFloat($this->digitAmount, $this->precision);

        $this->assertEquals($this->digitAmount, $float->getDigitsAmount());
        $this->assertEquals($this->precision, $float->getPrecision());

    }

    public function testCreate_withNegativeDigitsAmount_throwsFloatException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeFloat($this->digitAmount * -1, $this->precision, true);

        } catch (FloatException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNegativePrecision_throwsFloatException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeFloat($this->digitAmount, $this->precision * -1, true);

        } catch (FloatException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroDigitsAmount_throwsFloatException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeFloat(0, $this->precision, true);

        } catch (FloatException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withZeroPrecision_throwsFloatException() {

        $asserted = false;
        try {

            new ConcreteDatabaseTypeFloat($this->digitAmount, 0, true);

        } catch (FloatException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
