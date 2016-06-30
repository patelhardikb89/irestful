<?php
namespace iRESTful\Rodson\Tests\Helpers\Adapters;
use iRESTful\Rodson\Domain\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Domain\Codes\Methods\Method;
use iRESTful\Rodson\Domain\Codes\Methods\Exceptions\MethodException;

final class MethodAdapterHelper {
    private $phpunit;
    private $methodAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, MethodAdapter $methodAdapterMock) {
        $this->phpunit = $phpunit;
        $this->methodAdapterMock = $methodAdapterMock;
    }

    public function expectsFromStringToMethod_Success(Method $returnedMethod, $methodName) {
        $this->methodAdapterMock->expects($this->phpunit->once())
                                ->method('fromStringToMethod')
                                ->with($methodName)
                                ->will($this->phpunit->returnValue($returnedMethod));
    }

    public function expectsFromStringToMethod_throwsMethodException($methodName) {
        $this->methodAdapterMock->expects($this->phpunit->once())
                                ->method('fromStringToMethod')
                                ->with($methodName)
                                ->will($this->phpunit->throwException(new MethodException('TEST')));
    }

}
