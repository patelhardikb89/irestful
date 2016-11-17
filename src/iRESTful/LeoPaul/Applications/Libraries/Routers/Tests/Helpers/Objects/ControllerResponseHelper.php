<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\ControllerResponse;

final class ControllerResponseHelper {
    private $phpunit;
    private $controllerResponseMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ControllerResponse $controllerResponseMock) {
        $this->phpunit = $phpunit;
        $this->controllerResponseMock = $controllerResponseMock;
    }

    public function expectsGetHeaders_Success(array $returnedHeaders) {
        $this->controllerResponseMock->expects($this->phpunit->once())
                                        ->method('getHeaders')
                                        ->will($this->phpunit->returnValue($returnedHeaders));
    }

    public function expectsHasOutput_Success($returnedBoolean) {
        $this->controllerResponseMock->expects($this->phpunit->once())
                                        ->method('hasOutput')
                                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetOutput_Success($returnedString) {
        $this->controllerResponseMock->expects($this->phpunit->once())
                                        ->method('getOutput')
                                        ->will($this->phpunit->returnValue($returnedString));
    }

}
