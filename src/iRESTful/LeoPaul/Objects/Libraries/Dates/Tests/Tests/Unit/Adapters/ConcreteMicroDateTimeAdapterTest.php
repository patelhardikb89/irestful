<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Adapters\DateTimeAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteMicroDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Exceptions\MicroDateTimeException;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Objects\MicroDateTimeHelper;

final class ConcreteMicroDateTimeAdapterTest extends \PHPUnit_Framework_TestCase {
	private $dateTimeAdapterMock;
	private $microDateTimeMock;
	private $dateTime;
	private $microTime;
	private $timestamp;
	private $microSeconds;
	private $data;
	private $adapter;
	private $dateTimeAdapterHelper;
	private $microDateTimeHelper;
	public function setUp() {

		$this->dateTimeAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter');
		$this->microDateTimeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime');

		$this->microTime = microtime();
		$exploded = explode(' ', $this->microTime);
		$this->timestamp = $exploded[1];
		$this->microSeconds = (int) (((float) $exploded[0]) * 1000000);

		$this->dateTime = new \DateTime();
		$this->dateTime->setTimestamp($this->timestamp);

		$this->data = [
			'timestamp' => $this->timestamp,
			'micro_seconds' => $this->microSeconds
		];

		$this->adapter = new ConcreteMicroDateTimeAdapter($this->dateTimeAdapterMock);

		$this->dateTimeAdapterHelper = new DateTimeAdapterHelper($this, $this->dateTimeAdapterMock);
		$this->microDateTimeHelper = new MicroDateTimeHelper($this, $this->microDateTimeMock);
	}

	public function tearDown() {

	}

	public function testFromStringToMicroDateTime_Success() {

		$this->dateTimeAdapterHelper->expectsFromTimestampToDateTime_Success($this->dateTime, $this->timestamp);

		$microDateTime = $this->adapter->fromStringToMicroDateTime($this->microTime);

		$this->assertTrue($microDateTime instanceof \iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime);
		$this->assertEquals($this->dateTime, $microDateTime->getDateTime());
		$this->assertEquals($this->microSeconds, $microDateTime->getMicroSeconds());

	}

	public function testFromStringToMicroDateTime_throwsDateTimeException_throwsMicroDateTimeException() {

		$this->dateTimeAdapterHelper->expectsFromTimestampToDateTime_throwsDateTimeException($this->timestamp);

		$asserted = false;
		try {

			$this->adapter->fromStringToMicroDateTime($this->microTime);

		} catch (MicroDateTimeException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromStringToMicroDateTime_withInvalidMicroTimeString_throwsMicroDateTimeException() {

		$asserted = false;
		try {

			$this->adapter->fromStringToMicroDateTime('not a valid micro time string.');

		} catch (MicroDateTimeException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromMicroDateTimeToData_Success() {

		$this->microDateTimeHelper->expectsGetDateTime_Success($this->dateTime);
		$this->microDateTimeHelper->expectsGetMicroSeconds_Success($this->microSeconds);

		$data = $this->adapter->fromMicroDateTimeToData($this->microDateTimeMock);

		$this->assertEquals($this->data, $data);

	}

	public function testFromDataToMicroDateTime_Success() {

		$this->dateTimeAdapterHelper->expectsFromTimestampToDateTime_Success($this->dateTime, $this->timestamp);

		$microDateTime = $this->adapter->fromDataToMicroDateTime($this->data);

		$this->assertEquals($this->dateTime, $microDateTime->getDateTime());
		$this->assertEquals($this->microSeconds, $microDateTime->getMicroSeconds());

	}

	public function testFromDataToMicroDateTime_withoutMicroSeconds_Success() {

		unset($this->data['micro_seconds']);

		$this->dateTimeAdapterHelper->expectsFromTimestampToDateTime_Success($this->dateTime, $this->timestamp);

		$microDateTime = $this->adapter->fromDataToMicroDateTime($this->data);

		$this->assertEquals($this->dateTime, $microDateTime->getDateTime());
		$this->assertEquals(0, $microDateTime->getMicroSeconds());

	}

	public function testFromDataToMicroDateTime_throwsDateTimeException_throwsMicroDateTimeException() {

		$this->dateTimeAdapterHelper->expectsFromTimestampToDateTime_throwsDateTimeException($this->timestamp);

		$asserted = false;
		try {

			$this->adapter->fromDataToMicroDateTime($this->data);

		} catch (MicroDateTimeException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}
	public function testFromDataToMicroDateTime_withoutTimestamp_throwsMicroDateTimeException() {

		unset($this->data['timestamp']);

		$asserted = false;
		try {

			$this->adapter->fromDataToMicroDateTime($this->data);

		} catch (MicroDateTimeException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
