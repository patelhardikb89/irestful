<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dimensions\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Tests\Helpers\Adapters\DimensionAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Exceptions\DimensionException;

final class DimensionAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $dimensionAdapterMock;
    private $dimensionMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->dimensionAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Adapters\DimensionAdapter');
        $this->dimensionMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Dimension');

        $this->data = [
            'some' => 'data'
        ];

        $this->helper = new DimensionAdapterHelper($this, $this->dimensionAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToDimension_Success() {

        $this->helper->expectsFromDataToDimension_Success($this->dimensionMock, $this->data);

        $dimension = $this->dimensionAdapterMock->fromDataToDimension($this->data);

        $this->assertEquals($this->dimensionMock, $dimension);

    }

    public function testFromDataToDimension_multiple_Success() {

        $this->helper->expectsFromDataToDimension_multiple_Success([$this->dimensionMock, $this->dimensionMock], [$this->data, $this->data]);

        $firstDimension = $this->dimensionAdapterMock->fromDataToDimension($this->data);
        $secondDimension = $this->dimensionAdapterMock->fromDataToDimension($this->data);

        $this->assertEquals($this->dimensionMock, $firstDimension);
        $this->assertEquals($this->dimensionMock, $secondDimension);

    }

    public function testFromDataToDimension_throwsDimensionException() {

        $this->helper->expectsFromDataToDimension_throwsDimensionException($this->data);

        $asserted = false;
        try {

            $this->dimensionAdapterMock->fromDataToDimension($this->data);

        } catch (DimensionException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
