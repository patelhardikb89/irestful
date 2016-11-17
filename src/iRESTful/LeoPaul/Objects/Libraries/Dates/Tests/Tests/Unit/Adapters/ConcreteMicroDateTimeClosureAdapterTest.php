<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteMicroDateTimeClosureAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Factories\MicroDateTimeFactoryHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Objects\MicroDateTimeHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Exceptions\MicroDateTimeException;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Exceptions\MicroDateTimeClosureException;

final class ConcreteMicroDateTimeClosureAdapterTest extends \PHPUnit_Framework_TestCase {
	private $microDateTimeFactoryMock;
	private $microDateTimeMock;
	private $adapter;
	private $microDateTimeFactoryHelper;
	private $microDateTimeHelper;
	public function setUp() {

		$this->microDateTimeFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Factories\MicroDateTimeFactory');
		$this->microDateTimeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime');

		$this->adapter = new ConcreteMicroDateTimeClosureAdapter($this->microDateTimeFactoryMock);

		$this->microDateTimeFactoryHelper = new MicroDateTimeFactoryHelper($this, $this->microDateTimeFactoryMock);
		$this->microDateTimeHelper = new MicroDateTimeHelper($this, $this->microDateTimeMock);
	}

	public function tearDown() {

	}

	public function testFromClosureToMicroDateTimeClosure_Success() {

		$hasBeenExecuted = false;
		$closure = function() use(&$hasBeenExecuted) {
			$hasBeenExecuted = true;
		};

		$this->microDateTimeFactoryHelper->expectsCreate_multiple_Success([
			$this->microDateTimeMock,
			$this->microDateTimeMock
		]);

		$this->microDateTimeHelper->expectsIsBefore_Success(true, $this->microDateTimeMock);

		$microDateTimeClosure = $this->adapter->fromClosureToMicroDateTimeClosure($closure);

		$this->assertEquals($closure, $microDateTimeClosure->getClosure());
		$this->assertTrue($hasBeenExecuted);
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->startedOn());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->endsOn());
		$this->assertFalse($microDateTimeClosure->hasResults());
		$this->assertNull($microDateTimeClosure->getResults());
	}

	public function testFromClosureToMicroDateTimeClosure_withInvalidMicroDateTime_throwsMicroDateTimeException_throwsMicroDateTimeClosureException() {

		$hasBeenExecuted = false;
		$closure = function() use(&$hasBeenExecuted) {
			$hasBeenExecuted = true;
		};

		$this->microDateTimeFactoryHelper->expectsCreate_multiple_Success([
			$this->microDateTimeMock,
			$this->microDateTimeMock
		]);

		$this->microDateTimeHelper->expectsIsBefore_Success(false, $this->microDateTimeMock);

		$asserted = false;
		try {

			$this->adapter->fromClosureToMicroDateTimeClosure($closure);

		} catch (MicroDateTimeClosureException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testFromClosureToMicroDateTimeClosure_throwsMicroDateTimeException_throwsMicroDateTimeClosureException() {

		$this->microDateTimeFactoryHelper->expectsCreate_throwsMicroDateTimeException();

		$asserted = false;
		try {

			$this->adapter->fromClosureToMicroDateTimeClosure(function() {

			});

		} catch (MicroDateTimeClosureException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testFromClosureToMicroDateTimeClosure_throwsExceptionInClosure_throwsMicroDateTimeClosureException() {

		$this->microDateTimeFactoryHelper->expectsCreate_Success($this->microDateTimeMock);

		$asserted = false;
		try {

			$this->adapter->fromClosureToMicroDateTimeClosure(function() {
				throw new \Exception('TEST');
			});

		} catch (MicroDateTimeClosureException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);
	}

	public function testFromClosureToMicroDateTimeClosure_withResults_Success() {

		$hasBeenExecuted = false;
		$results = [
			'some' => 'results'
		];
		$closure = function() use(&$hasBeenExecuted, $results) {
			$hasBeenExecuted = true;
			return $results;
		};

		$this->microDateTimeFactoryHelper->expectsCreate_multiple_Success([
			$this->microDateTimeMock,
			$this->microDateTimeMock
		]);

		$this->microDateTimeHelper->expectsIsBefore_Success(true, $this->microDateTimeMock);

		$microDateTimeClosure = $this->adapter->fromClosureToMicroDateTimeClosure($closure);

		$this->assertEquals($closure, $microDateTimeClosure->getClosure());
		$this->assertTrue($hasBeenExecuted);
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->startedOn());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->endsOn());
		$this->assertTrue($microDateTimeClosure->hasResults());
		$this->assertEquals($results, $microDateTimeClosure->getResults());
	}

	public function testFromClosureToMicroDateTimeClosure_withStringResults_Success() {

		$hasBeenExecuted = false;
		$results = 'this is a string result.';
		$closure = function() use(&$hasBeenExecuted, $results) {
			$hasBeenExecuted = true;
			return $results;
		};

		$this->microDateTimeFactoryHelper->expectsCreate_multiple_Success([
			$this->microDateTimeMock,
			$this->microDateTimeMock
		]);

		$this->microDateTimeHelper->expectsIsBefore_Success(true, $this->microDateTimeMock);

		$microDateTimeClosure = $this->adapter->fromClosureToMicroDateTimeClosure($closure);

		$this->assertEquals($closure, $microDateTimeClosure->getClosure());
		$this->assertTrue($hasBeenExecuted);
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->startedOn());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->endsOn());
		$this->assertTrue($microDateTimeClosure->hasResults());
		$this->assertEquals($results, $microDateTimeClosure->getResults());
	}

}
