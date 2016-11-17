<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Objects\ConcreteHttpRoute;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class ConcreteHttpRouteTest extends \PHPUnit_Framework_TestCase {
	private $method;
	private $endpoint;
	private $className;
	public function setUp() {
		$this->method = 'post';
		$this->endpoint = '/container';
		$this->className = 'iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Objects\ConcreteHttpRouteTest';
	}

	public function tearDown() {

	}

	public function testCreate_Success() {

		$route = new ConcreteHttpRoute($this->method, $this->endpoint, $this->className);

		$this->assertEquals($this->method, $route->getMethod());
		$this->assertEquals($this->endpoint, $route->getEndpoint());
		$this->assertEquals($this->className, $route->getClassName());

	}

	public function testCreate_withInvalidClassName_Success() {

		$asserted = false;
		try {

			new ConcreteHttpRoute($this->method, $this->endpoint, 'InvalidClassName');

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withInvalidMethod_Success() {

		$asserted = false;
		try {

			new ConcreteHttpRoute('invalid method', $this->endpoint, $this->className);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyClassName_Success() {

		$asserted = false;
		try {

			new ConcreteHttpRoute($this->method, $this->endpoint, '');

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyEndpoint_Success() {

		$asserted = false;
		try {

			new ConcreteHttpRoute($this->method, '', $this->className);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withEmptyMethod_Success() {

		$asserted = false;
		try {

			new ConcreteHttpRoute('', $this->endpoint, $this->className);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNonStringMethod_Success() {

		$asserted = false;
		try {

			new ConcreteHttpRoute(new \DateTime(), $this->endpoint, $this->className);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNonStringEndpoint_Success() {

		$asserted = false;
		try {

			new ConcreteHttpRoute($this->method, new \DateTime(), $this->className);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withNonStringClassName_Success() {

		$asserted = false;
		try {

			new ConcreteHttpRoute($this->method, $this->endpoint, new \DateTime());

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}


}
