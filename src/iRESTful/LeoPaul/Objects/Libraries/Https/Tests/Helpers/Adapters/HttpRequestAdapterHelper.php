<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\Adapters\HttpRequestAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class HttpRequestAdapterHelper {
	private $phpunit;
	private $httpRequestAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, HttpRequestAdapter $httpRequestAdapterMock) {
		$this->phpunit = $phpunit;
		$this->httpRequestAdapterMock = $httpRequestAdapterMock;
	}

	public function expectsFromDataToHttpRequest_Success(HttpRequest $returnedHttpRequest, array $data) {
		$this->httpRequestAdapterMock->expects($this->phpunit->once())
										->method('fromDataToHttpRequest')
										->with($data)
										->will($this->phpunit->returnValue($returnedHttpRequest));
	}

	public function expectsFromDataToHttpRequest_throwsHttpException(array $data) {
		$this->httpRequestAdapterMock->expects($this->phpunit->once())
										->method('fromDataToHttpRequest')
										->with($data)
										->will($this->phpunit->throwException(new HttpException('TEST')));
	}

}
