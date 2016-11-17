<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Factories\DateTimeFactoryHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Exceptions\DateTimeException;

final class DateTimeFactoryHelperTest extends \PHPUnit_Framework_TestCase {
	private $dateTimeFactoryMock;
	private $dateTime;
	private $helper;
	public function setUp() {
		$this->dateTimeFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Factories\DateTimeFactory');
		$this->dateTime = new \DateTime();
		$this->helper = new DateTimeFactoryHelper($this, $this->dateTimeFactoryMock);
	}

	public function tearDown() {

	}

    public function testCreate_Success() {

		$this->helper->expectsCreate_Success($this->dateTime);

		$dateTime = $this->dateTimeFactoryMock->create();

		$this->assertEquals($this->dateTime, $dateTime);

	}

    public function testCreate_multiple_Success() {

		$this->helper->expectsCreate_multiple_Success([$this->dateTime, $this->dateTime]);

		$firstDateTime = $this->dateTimeFactoryMock->create();
        $secondDateTime = $this->dateTimeFactoryMock->create();

		$this->assertEquals($this->dateTime, $firstDateTime);
        $this->assertEquals($this->dateTime, $secondDateTime);

	}

	public function testCreate_throwsDateTimeException() {

		$this->helper->expectsCreate_throwsDateTimeException();

		$asserted = false;
		try {

			$this->dateTimeFactoryMock->create();

		} catch (DateTimeException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
