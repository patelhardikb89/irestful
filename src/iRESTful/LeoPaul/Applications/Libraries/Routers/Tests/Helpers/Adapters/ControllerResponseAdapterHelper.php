<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\ControllerResponse;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Exceptions\ControllerResponseException;

final class ControllerResponseAdapterHelper {
    private $phpunit;
    private $controllerResponseAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ControllerResponseAdapter $controllerResponseAdapterMock) {
        $this->phpunit = $phpunit;
        $this->controllerResponseAdapterMock = $controllerResponseAdapterMock;
    }

    public function expectsFromDataToControllerResponse_Success(ControllerResponse $returnedResponse, array $data) {
        $this->controllerResponseAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToControllerResponse')
                                            ->with($data)
                                            ->will($this->phpunit->returnValue($returnedResponse));
    }

    public function expectsFromDataToControllerResponse_throwsControllerResponseException(array $data) {
        $this->controllerResponseAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToControllerResponse')
                                            ->with($data)
                                            ->will($this->phpunit->throwException(new ControllerResponseException('TEST')));
    }

}
