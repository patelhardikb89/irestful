<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dimensions\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Infrastructure\Objects\ConcreteDimension;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Exceptions\DimensionException;

final class ConcreteDimensionTest extends \PHPUnit_Framework_TestCase {
    private $width;
    private $height;
    public function setUp() {
        $this->width = rand(1, 500);
        $this->height = rand(1, 500);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $dimension = new ConcreteDimension($this->width, $this->height);

        $this->assertEquals($this->width, $dimension->getWidth());
        $this->assertEquals($this->height, $dimension->getHeight());

    }

    public function testCreate_withZeroWidth_throwsDimensionException() {

        $asserted = false;
        try {

            new ConcreteDimension(0, $this->height);

        } catch (DimensionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withZeroHeight_throwsDimensionException() {

        $asserted = false;
        try {

            new ConcreteDimension($this->width, 0);

        } catch (DimensionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withStringWidth_throwsDimensionException() {

        $asserted = false;
        try {

            new ConcreteDimension('44', $this->height);

        } catch (DimensionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withStringHeight_throwsDimensionException() {

        $asserted = false;
        try {

            new ConcreteDimension($this->width, '67');

        } catch (DimensionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withInvalidWidth_throwsDimensionException() {

        $asserted = false;
        try {

            new ConcreteDimension(new \DateTime(), $this->height);

        } catch (DimensionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withInvalidHeight_throwsDimensionException() {

        $asserted = false;
        try {

            new ConcreteDimension($this->width, new \DateTime());

        } catch (DimensionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
