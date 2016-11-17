<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters\ResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Exceptions\ResponseException;

final class ResponseAdapterHelper {
    private $phpunit;
    private $responseAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ResponseAdapter $responseAdapterMock) {
        $this->phpunit = $phpunit;
        $this->responseAdapterMock = $responseAdapterMock;
    }

    public function expectsFromHttpResponseToData_Success(array $returnedData, HttpResponse $httpResponseMock) {
        $this->responseAdapterMock->expects($this->phpunit->once())
                                    ->method('fromHttpResponseToData')
                                    ->with($httpResponseMock)
                                    ->will($this->phpunit->returnValue($returnedData));
    }

    public function expectsFromHttpResponseToData_returnsNull_Success(HttpResponse $httpResponseMock) {
        $this->responseAdapterMock->expects($this->phpunit->once())
                                    ->method('fromHttpResponseToData')
                                    ->with($httpResponseMock)
                                    ->will($this->phpunit->returnValue(null));
    }

    public function expectsFromHttpResponseToData_throwsResponseException(HttpResponse $httpResponseMock) {
        $this->responseAdapterMock->expects($this->phpunit->once())
                                    ->method('fromHttpResponseToData')
                                    ->with($httpResponseMock)
                                    ->will($this->phpunit->throwException(new ResponseException('TEST')));
    }

}
