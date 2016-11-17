<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Adapters\HttpRouteAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class HttpRouteAdapterHelperTest extends \PHPUnit_Framework_TestCase {
	private $httpRouteAdapterMock;
	private $httpRouteMock;
	private $data;
	private $helper;
	public function setUp() {
		$this->httpRouteAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Routes\Adapters\HttpRouteAdapter');
		$this->httpRouteMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Routes\HttpRoute');

		$this->data = [
			'my' => 'data'
		];

		$this->helper = new HttpRouteAdapterHelper($this, $this->httpRouteAdapterMock);
	}

	public function tearDown() {

	}

	public function testFromDataToHttpRoute_Success() {

		$this->helper->expectsFromDataToHttpRoute_Success($this->httpRouteMock, $this->data);

		$httpRoute = $this->httpRouteAdapterMock->fromDataToHttpRoute($this->data);

		$this->assertEquals($this->httpRouteMock, $httpRoute);

	}

	public function testFromDataToHttpRoute_throwsHttpException() {

		$this->helper->expectsFromDataToHttpRoute_throwsHttpException($this->data);

		$asserted = false;
		try {

			$this->httpRouteAdapterMock->fromDataToHttpRoute($this->data);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToHttpRoutes_Success() {

		$this->helper->expectsFromDataToHttpRoutes_Success([$this->httpRouteMock], [$this->data]);

		$httpRoutes = $this->httpRouteAdapterMock->fromDataToHttpRoutes([$this->data]);

		$this->assertEquals([$this->httpRouteMock], $httpRoutes);

	}

	public function testFromDataToHttpRoutes_throwsHttpException() {

		$this->helper->expectsFromDataToHttpRoutes_throwsHttpException([$this->data]);

		$asserted = false;
		try {

			$this->httpRouteAdapterMock->fromDataToHttpRoutes([$this->data]);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
