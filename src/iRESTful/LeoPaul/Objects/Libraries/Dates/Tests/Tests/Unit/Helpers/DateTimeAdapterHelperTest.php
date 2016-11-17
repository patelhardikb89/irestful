<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Adapters\DateTimeAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Exceptions\DateTimeException;

final class DateTimeAdapterHelperTest extends \PHPUnit_Framework_TestCase {
	private $dateTimeAdapterMock;
	private $timestamp;
	private $dateTime;
	private $helper;
	public function setUp() {
		$this->dateTimeAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter');

		$this->timestamp = time();
		$this->dateTime = new \DateTime();
		$this->dateTime->setTimestamp($this->timestamp);

		$this->helper = new DateTimeAdapterHelper($this, $this->dateTimeAdapterMock);
	}

	public function tearDown() {

	}

	public function testfromTimestampToDateTime_Success() {

		$this->helper->expectsFromTimestampToDateTime_Success($this->dateTime, $this->timestamp);

		$dateTime = $this->dateTimeAdapterMock->fromTimestampToDateTime($this->timestamp);

		$this->assertEquals($this->dateTime, $dateTime);

	}

	public function testfromTimestampToDateTime_throwsDateTimeException() {

		$this->helper->expectsFromTimestampToDateTime_throwsDateTimeException($this->timestamp);

		$asserted = false;
		try {

			$this->dateTimeAdapterMock->fromTimestampToDateTime($this->timestamp);

		} catch (DateTimeException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
