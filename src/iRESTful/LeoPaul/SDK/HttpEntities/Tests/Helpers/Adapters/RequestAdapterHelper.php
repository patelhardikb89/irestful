<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Adapters\RequestAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Exceptions\RequestException;

final class RequestAdapterHelper {
    private $phpunit;
    private $requestAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RequestAdapter $requestAdapterMock) {
        $this->phpunit = $phpunit;
        $this->requestAdapterMock = $requestAdapterMock;
    }

    public function expectsFromDataToEntityHttpRequestData_Success(array $returnedHttpRequest, array $data) {
        $this->requestAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToEntityHttpRequestData')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedHttpRequest));
    }

    public function expectsFromDataToEntityHttpRequestData_throwsRequestException(array $data) {
        $this->requestAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToEntityHttpRequestData')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new RequestException('TEST')));
    }

}
