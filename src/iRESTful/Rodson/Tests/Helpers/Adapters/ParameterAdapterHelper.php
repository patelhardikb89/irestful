<?php
namespace iRESTful\Rodson\Tests\Helpers\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Parameters\Parameter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Parameters\Exceptions\ParameterException;

final class ParameterAdapterHelper {
    private $phpunit;
    private $parameterAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ParameterAdapter $parameterAdapterMock) {
        $this->phpunit = $phpunit;
        $this->parameterAdapterMock = $parameterAdapterMock;
    }

    public function expectsFromTypeToParameter_Success(Parameter $returnedParameter, Type $type) {
        $this->parameterAdapterMock->expects($this->phpunit->once())
                                    ->method('fromTypeToParameter')
                                    ->with($type)
                                    ->will($this->phpunit->returnValue($returnedParameter));
    }

    public function expectsFromTypeToParameter_throwsParameterException(Type $type) {
        $this->parameterAdapterMock->expects($this->phpunit->once())
                                    ->method('fromTypeToParameter')
                                    ->with($type)
                                    ->will($this->phpunit->throwException(new ParameterException('TEST')));
    }

}
