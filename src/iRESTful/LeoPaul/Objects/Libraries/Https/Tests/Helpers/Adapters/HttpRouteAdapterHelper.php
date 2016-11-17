<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Routes\Adapters\HttpRouteAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Routes\HttpRoute;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class HttpRouteAdapterHelper {
	private $phpunit;
	private $httpRouteAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, HttpRouteAdapter $httpRouteAdapterMock) {
		$this->phpunit = $phpunit;
		$this->httpRouteAdapterMock = $httpRouteAdapterMock;
	}

	public function expectsFromDataToHttpRoute_Success(HttpRoute $returnedHttpRoute, array $data) {
		$this->httpRouteAdapterMock->expects($this->phpunit->once())
									->method('fromDataToHttpRoute')
									->with($data)
									->will($this->phpunit->returnValue($returnedHttpRoute));
	}

	public function expectsFromDataToHttpRoute_throwsHttpException(array $data) {
		$this->httpRouteAdapterMock->expects($this->phpunit->once())
									->method('fromDataToHttpRoute')
									->with($data)
									->will($this->phpunit->throwException(new HttpException('TEST')));
	}

	public function expectsFromDataToHttpRoutes_Success(array $returnedHttpRoutes, array $data) {
		$this->httpRouteAdapterMock->expects($this->phpunit->once())
									->method('fromDataToHttpRoutes')
									->with($data)
									->will($this->phpunit->returnValue($returnedHttpRoutes));
	}

	public function expectsFromDataToHttpRoutes_throwsHttpException(array $data) {
		$this->httpRouteAdapterMock->expects($this->phpunit->once())
									->method('fromDataToHttpRoutes')
									->with($data)
									->will($this->phpunit->throwException(new HttpException('TEST')));
	}

}
