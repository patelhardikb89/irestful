<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\ConcreteHttpRouteAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class ConcreteHttpRouteAdapterTest extends \PHPUnit_Framework_TestCase {
	private $method;
	private $endpoint;
	private $className;
	private $data;
	private $secondData;
	private $adapter;
	public function setUp() {

		$this->method = 'post';
		$this->endpoint = '/container';
		$this->className = 'iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Objects\ConcreteHttpRouteTest';

		$this->data = [
			'method' => $this->method,
			'endpoint' => $this->endpoint,
			'class' => $this->className
		];

		$this->secondData = [
			'method' => 'get',
			'endpoint' => '/test',
			'class' => 'iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Adapters\ConcreteHttpRequestAdapterTest'
		];

		$this->adapter = new ConcreteHttpRouteAdapter();
	}

	public function tearDown() {

	}

	public function testFromDataToHttpRoute_Success() {

		$route = $this->adapter->fromDataToHttpRoute($this->data);

		$this->assertEquals($this->method, $route->getMethod());
		$this->assertEquals($this->endpoint, $route->getEndpoint());
		$this->assertEquals($this->className, $route->getClassName());

	}

	public function testFromDataToHttpRoute_withoutMethod_throwsHttpException() {

		$asserted = false;
		try {

			unset($this->data['method']);
			$this->adapter->fromDataToHttpRoute($this->data);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToHttpRoute_withoutEndpoint_throwsHttpException() {

		$asserted = false;
		try {

			unset($this->data['endpoint']);
			$this->adapter->fromDataToHttpRoute($this->data);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToHttpRoute_withoutClass_throwsHttpException() {

		$asserted = false;
		try {

			unset($this->data['class']);
			$this->adapter->fromDataToHttpRoute($this->data);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromDataToHttpRoutes_Success() {

		$routes = $this->adapter->fromDataToHttpRoutes([$this->data, $this->secondData]);

		$this->assertEquals(2, count($routes));

		$this->assertEquals($this->method, $routes[0]->getMethod());
		$this->assertEquals($this->endpoint, $routes[0]->getEndpoint());
		$this->assertEquals($this->className, $routes[0]->getClassName());

		$this->assertEquals($this->secondData['method'], $routes[1]->getMethod());
		$this->assertEquals($this->secondData['endpoint'], $routes[1]->getEndpoint());
		$this->assertEquals($this->secondData['class'], $routes[1]->getClassName());
	}

}
