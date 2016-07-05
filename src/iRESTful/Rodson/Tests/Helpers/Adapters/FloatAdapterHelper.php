<?php
namespace iRESTful\Rodson\Tests\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Floats\Adapters\FloatAdapter;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Floats\Float;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Floats\Exceptions\FloatException;

final class FloatAdapterHelper {
    private $phpunit;
    private $floatAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, FloatAdapter $floatAdapterMock) {
        $this->phpunit = $phpunit;
        $this->floatAdapterMock = $floatAdapterMock;
    }

    public function expectsFromDataToFloat_Success(Float $returnedFloat, array $data) {
        $this->floatAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToFloat')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedFloat));
    }

    public function expectsFromDataToFloat_throwsFloatException(array $data) {
        $this->floatAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToFloat')
                                ->with($data)
                                ->will($this->phpunit->throwException(new FloatException('TEST')));
    }

}
