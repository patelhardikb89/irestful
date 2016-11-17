<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Adapters\HttpRequestAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class HttpRequestAdapterHelperTest extends \PHPUnit_Framework_TestCase {
	private $httpRequestAdapterMock;
	private $httpRequestMock;
	private $data;
	private $helper;
	public function setUp() {
		$this->httpRequestAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\Adapters\HttpRequestAdapter');
		$this->httpRequestMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest');

		$this->data = [
			'first' => 'data'
		];

		$this->helper = new HttpRequestAdapterHelper($this, $this->httpRequestAdapterMock);
	}

	public function tearDown() {

	}

	public function testFromDataToHttpRequest_Success() {

		$this->helper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->data);

		$httpRequest = $this->httpRequestAdapterMock->fromDataToHttpRequest($this->data);

		$this->assertEquals($this->httpRequestMock, $httpRequest);

	}

	public function testFromDataToHttpRequest_throwsHttpException() {

		$this->helper->expectsFromDataToHttpRequest_throwsHttpException($this->data);

		$asserted = false;
		try {

			$this->httpRequestAdapterMock->fromDataToHttpRequest($this->data);

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
