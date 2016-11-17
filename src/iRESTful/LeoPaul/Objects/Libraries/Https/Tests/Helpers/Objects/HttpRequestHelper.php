<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;

final class HttpRequestHelper {
	private $phpunit;
	private $requestMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, HttpRequest $requestMock) {
		$this->phpunit = $phpunit;
		$this->requestMock = $requestMock;
	}

	public function expectsGetURI_Success($returnedURI) {

		$this->requestMock->expects($this->phpunit->once())
							->method('getURI')
							->will($this->phpunit->returnValue($returnedURI));

	}

	public function expectsGetMethod_Success($returnedMethod) {

		$this->requestMock->expects($this->phpunit->once())
							->method('getMethod')
							->will($this->phpunit->returnValue($returnedMethod));

	}

	public function expectsGetPort_Success($returnedPort) {

		$this->requestMock->expects($this->phpunit->once())
							->method('getPort')
							->will($this->phpunit->returnValue($returnedPort));

	}

	public function expectsHasQueryParameters_Success($returnedBoolean) {

		$this->requestMock->expects($this->phpunit->once())
							->method('hasQueryParameters')
							->will($this->phpunit->returnValue($returnedBoolean));

	}

	public function expectsGetQueryParameters_Success(array $returnedQueryParameters) {

		$this->requestMock->expects($this->phpunit->once())
							->method('getQueryParameters')
							->will($this->phpunit->returnValue($returnedQueryParameters));

	}

    public function expectsHasRequestParameters_Success($returnedBoolean) {

		$this->requestMock->expects($this->phpunit->once())
							->method('hasRequestParameters')
							->will($this->phpunit->returnValue($returnedBoolean));

	}

	public function expectsGetRequestParameters_Success(array $returnedRequestParameters) {

		$this->requestMock->expects($this->phpunit->once())
							->method('getRequestParameters')
							->will($this->phpunit->returnValue($returnedRequestParameters));

	}

    public function expectsHasParameters_Success($returnedBoolean) {

		$this->requestMock->expects($this->phpunit->once())
							->method('hasParameters')
							->will($this->phpunit->returnValue($returnedBoolean));

	}

	public function expectsGetParameters_Success(array $returnedRequestParameters) {

		$this->requestMock->expects($this->phpunit->once())
							->method('getParameters')
							->will($this->phpunit->returnValue($returnedRequestParameters));

	}

	public function expectsHasHeaders_Success($returnedBoolean) {

		$this->requestMock->expects($this->phpunit->once())
							->method('hasHeaders')
							->will($this->phpunit->returnValue($returnedBoolean));

	}

	public function expectsGetHeaders_Success(array $headers) {

		$this->requestMock->expects($this->phpunit->once())
							->method('getHeaders')
							->will($this->phpunit->returnValue($headers));

	}

	public function expectsHasFilePath_Success($returnedBoolean) {

		$this->requestMock->expects($this->phpunit->once())
							->method('hasFilePath')
							->will($this->phpunit->returnValue($returnedBoolean));

	}

    public function expectsGetFilePath_Success($returnedFilePath) {

		$this->requestMock->expects($this->phpunit->once())
							->method('getFilePath')
							->will($this->phpunit->returnValue($returnedFilePath));

	}

    public function expectsProcess_Success(Httprequest $returnedHttpRequest, $uriPattern) {

		$this->requestMock->expects($this->phpunit->once())
							->method('process')
                            ->with($uriPattern)
							->will($this->phpunit->returnValue($returnedHttpRequest));

	}

}
