<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Objects\MicroDateTimeHelper;

final class MicroDateTimeHelperTest extends \PHPUnit_Framework_TestCase {
	private $microDateTimeMock;
	private $dateTime;
	private $microSeconds;
	private $helper;
	public function setUp() {
		$this->microDateTimeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime');

		$this->dateTime = new \DateTime();
		$this->microSeconds = rand(1, 100);

		$this->helper = new MicroDateTimeHelper($this, $this->microDateTimeMock);
	}

	public function tearDown() {

	}

	public function testGetDateTime_Success() {

		$this->helper->expectsGetDateTime_Success($this->dateTime);

		$dateTime = $this->microDateTimeMock->getDateTime();

		$this->assertEquals($this->dateTime, $dateTime);

	}

	public function testGetMicroSeconds_Success() {

		$this->helper->expectsGetMicroSeconds_Success($this->microSeconds);

		$microSeconds = $this->microDateTimeMock->getMicroSeconds();

		$this->assertEquals($this->microSeconds, $microSeconds);

	}

	public function testIsBefore_Success() {

		$this->helper->expectsIsBefore_Success(true, $this->microDateTimeMock);

		$isBefore = $this->microDateTimeMock->isBefore($this->microDateTimeMock);

		$this->assertTrue($isBefore);

	}

}
