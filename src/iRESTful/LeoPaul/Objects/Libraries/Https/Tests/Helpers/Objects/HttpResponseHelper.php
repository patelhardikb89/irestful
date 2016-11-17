<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse;

final class HttpResponseHelper {
    private $phpunit;
    private $httpResponseMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, HttpResponse $httpResponseMock) {
        $this->phpunit = $phpunit;
        $this->httpResponseMock = $httpResponseMock;
    }

    public function expectsGetCode_Success($returnedCode) {
        $this->httpResponseMock->expects($this->phpunit->once())
                                ->method('getCode')
                                ->will($this->phpunit->returnValue($returnedCode));
    }

    public function expectsGetContent_Success($returnedContent) {
        $this->httpResponseMock->expects($this->phpunit->once())
                                ->method('getContent')
                                ->will($this->phpunit->returnValue($returnedContent));
    }

    public function expectsHasHeaders_Success($returnedBoolean) {
        $this->httpResponseMock->expects($this->phpunit->once())
                                ->method('hasHeaders')
                                ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetHeaders_Success(array $returnedHeaders) {
        $this->httpResponseMock->expects($this->phpunit->once())
                                ->method('getHeaders')
                                ->will($this->phpunit->returnValue($returnedHeaders));
    }

}
