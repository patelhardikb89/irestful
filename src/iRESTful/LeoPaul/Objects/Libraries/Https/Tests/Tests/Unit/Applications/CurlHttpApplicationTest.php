<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Applications;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Applications\CurlHttpApplication;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class CurlHttpApplicationTest extends \PHPUnit_Framework_TestCase {
    private $httpRequestAdapterMock;
	public function setUp() {
        $this->httpRequestAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\Adapters\HttpRequestAdapter');
	}

	public function tearDown() {

	}

	public function testCreate_withInvalidBaseUrl_Success() {

		$asserted = false;
		try {

			new CurlHttpApplication($this->httpRequestAdapterMock, 'not a url');

		} catch (HttpException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}
}
