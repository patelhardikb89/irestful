<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Factories\ConcreteDateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Adapters\DateTimeAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Exceptions\DateTimeException;

final class ConcreteDateTimeFactoryTest extends \PHPUnit_Framework_TestCase {
	private $dateTimeAdapterMock;
	private $dateTime;
	private $timestamp;
	private $factory;
	private $dateTimeAdapterHelper;
	public function setUp() {
		$this->dateTimeAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter');
		$this->timestamp = time();

		$this->dateTime = new \DateTime();
		$this->dateTime->setTimestamp($this->timestamp);

		$this->factory = new ConcreteDateTimeFactory($this->dateTimeAdapterMock);
		$this->dateTimeAdapterHelper = new DateTimeAdapterHelper($this, $this->dateTimeAdapterMock);
	}

	public function tearDown() {

	}

	public function testCreate_Success() {

		$this->dateTimeAdapterHelper->expectsFromTimestampToDateTime_Success($this->dateTime, $this->timestamp);

		$dateTime = $this->factory->create();
        
        $this->assertTrue($dateTime->getTimestamp() <= time());

	}

	public function testCreate_throwsDateTimeException() {

		$this->dateTimeAdapterHelper->expectsFromTimestampToDateTime_throwsDateTimeException($this->timestamp);

		$asserted = false;
		try {

			$this->factory->create();

		} catch (DateTimeException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
