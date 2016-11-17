<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Factories\ConcreteMicroDateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Adapters\MicroDateTimeAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Exceptions\MicroDateTimeException;

final class ConcreteMicroDateTimeFactoryTest extends \PHPUnit_Framework_TestCase {
	private $microDateTimeAdapterMock;
	private $microDateTimeMock;
	private $factory;
	private $microDateTimeAdapterHelper;
	public function setUp() {

		$this->microDateTimeAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Adapters\MicroDateTimeAdapter');
		$this->microDateTimeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime');

		$this->factory = new ConcreteMicroDateTimeFactory($this->microDateTimeAdapterMock);

		$this->microDateTimeAdapterHelper = new MicroDateTimeAdapterHelper($this, $this->microDateTimeAdapterMock);

	}

	public function tearDown() {

	}

	public function testCreate_Success() {

		$this->microDateTimeAdapterHelper->expectsFromStringToMicroDateTime_withAnyString_Success($this->microDateTimeMock);

		$microDateTime = $this->factory->create();

		$this->assertEquals($this->microDateTimeMock, $microDateTime);

	}

	public function testCreate_throwsMicroDateTimeException() {

		$this->microDateTimeAdapterHelper->expectsFromStringToMicroDateTime_withAnyString_throwsMicroDateTimeException();

		$asserted = false;
		try {

			$this->factory->create();

		} catch (MicroDateTimeException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
