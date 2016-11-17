<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Objects\ConcreteMicroDateTime;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Exceptions\MicroDateTimeException;

final class ConcreteMicroDateTimeTest extends \PHPUnit_Framework_TestCase {
	private $dateTime;
	private $microSeconds;
	public function setUp() {
		$this->dateTime = new \DateTime();
		$this->dateTime->setTimestamp(time());

		$this->microSeconds = rand(10, 100);
	}

	public function tearDown() {

	}

	public function testCreate_Success() {

		$microDateTime = new ConcreteMicroDateTime($this->dateTime, $this->microSeconds);

		$this->assertEquals($this->dateTime, $microDateTime->getDateTime());
		$this->assertEquals($this->microSeconds, $microDateTime->getMicroSeconds());

		$afterDateTime = new \DateTime();
		$afterDateTime->setTimestamp(time() + 25 * 60 * 60);
		$afterMicroDateTime = new ConcreteMicroDateTime($afterDateTime, $this->microSeconds);
		$this->assertTrue($microDateTime->isBefore($afterMicroDateTime));

		$beforeDateTime = new \DateTime();
		$beforeDateTime->setTimestamp(time() - 25 * 60 * 60);
		$beforeMicroDateTime = new ConcreteMicroDateTime($beforeDateTime, $this->microSeconds);
		$this->assertFalse($microDateTime->isBefore($beforeMicroDateTime));

		$afterMicroDateTime = new ConcreteMicroDateTime($this->dateTime, rand(200, 1000));
		$this->assertTrue($microDateTime->isBefore($afterMicroDateTime));

		$beforeMicroDateTime = new ConcreteMicroDateTime($this->dateTime, rand(0, 9));
		$this->assertFalse($microDateTime->isBefore($beforeMicroDateTime));

	}

	public function testCreate_withInvalidMicroSeconds_throwsMicroDateTimeException() {

		$asserted = false;
		try {

			new ConcreteMicroDateTime($this->dateTime, (string) $this->microSeconds);

		} catch (MicroDateTimeException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
