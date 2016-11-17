<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dimensions\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Infrastructure\Adapters\ConcreteDimensionAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Exceptions\DimensionException;

final class ConcreteDimensionAdapterTest extends \PHPUnit_Framework_TestCase {
    private $width;
    private $height;
    private $data;
    private $dataWithStrings;
    private $adapter;
    public function setUp() {

        $this->width = rand(1, 500);
        $this->height = rand(1, 500);

        $this->data = [
            'width' => $this->width,
            'height' => $this->height
        ];

        $this->dataWithStrings = [
            'width' => (string) $this->width,
            'height' => (string) $this->height
        ];

        $this->adapter = new ConcreteDimensionAdapter();

    }

    public function tearDown() {

    }

    public function testFromDataToDimension_Success() {

        $dimension = $this->adapter->fromDataToDimension($this->data);

        $this->assertEquals($this->width, $dimension->getWidth());
        $this->assertEquals($this->height, $dimension->getHeight());

    }

    public function testFromDataToDimension_withStrings_Success() {

        $dimension = $this->adapter->fromDataToDimension($this->dataWithStrings);

        $this->assertEquals($this->width, $dimension->getWidth());
        $this->assertEquals($this->height, $dimension->getHeight());

    }

    public function testCreate_withoutWidthKeyname_throwsDimensionException() {

        unset($this->data['width']);

        $asserted = false;
        try {

            $this->adapter->fromDataToDimension($this->data);

        } catch (DimensionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withoutHeightKeyname_throwsDimensionException() {

        unset($this->data['height']);

        $asserted = false;
        try {

            $this->adapter->fromDataToDimension($this->data);

        } catch (DimensionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
