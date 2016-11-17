<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dimensions\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Adapters\DimensionAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Dimension;
use iRESTful\LeoPaul\Objects\Libraries\Dimensions\Domain\Exceptions\DimensionException;

final class DimensionAdapterHelper {
    private $phpunit;
    private $dimensionAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, DimensionAdapter $dimensionAdapterMock) {
        $this->phpunit = $phpunit;
        $this->dimensionAdapterMock = $dimensionAdapterMock;
    }

    public function expectsFromDataToDimension_Success(Dimension $returnedDimension, array $data) {
        $this->dimensionAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToDimension')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedDimension));
    }

    public function expectsFromDataToDimension_multiple_Success(array $returnedDimensions, array $data) {
        foreach($returnedDimensions as $index => $oneDimension) {
            $this->dimensionAdapterMock->expects($this->phpunit->at($index))
                                        ->method('fromDataToDimension')
                                        ->with($data[$index])
                                        ->will($this->phpunit->returnValue($oneDimension));
        }
    }

    public function expectsFromDataToDimension_throwsDimensionException(array $data) {
        $this->dimensionAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToDimension')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new DimensionException('TEST')));
    }

}
