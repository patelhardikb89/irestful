<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Objects\ConcreteMicroDateTimeClosure;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Objects\MicroDateTimeHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Exceptions\MicroDateTimeClosureException;

final class ConcreteMicroDateTimeClosureTest extends \PHPUnit_Framework_TestCase {
	private $microDateTimeMock;
	private $closure;
	private $results;
	private $stringResults;
	private $microDateTimeHelper;
	public function setUp() {
		$this->microDateTimeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime');
		$this->closure = function() {

		};

		$this->results = [
			'some' => 'results'
		];

		$this->stringResults = 'this is some results';

		$this->microDateTimeHelper = new MicroDateTimeHelper($this, $this->microDateTimeMock);
	}

	public function tearDown() {

	}

	public function testCreate_Success() {

		$this->microDateTimeHelper->expectsIsBefore_Success(true, $this->microDateTimeMock);

		$microDateTimeClosure = new ConcreteMicroDateTimeClosure($this->closure, $this->microDateTimeMock, $this->microDateTimeMock);

		$this->assertEquals($this->closure, $microDateTimeClosure->getClosure());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->startedOn());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->endsOn());
		$this->assertFalse($microDateTimeClosure->hasResults());
		$this->assertNull($microDateTimeClosure->getResults());

	}

	public function testCreate_startedOnIsAfterEndsOn_Success() {

		$this->microDateTimeHelper->expectsIsBefore_Success(false, $this->microDateTimeMock);

		$asserted = false;
		try {

			new ConcreteMicroDateTimeClosure($this->closure, $this->microDateTimeMock, $this->microDateTimeMock);

		} catch (MicroDateTimeClosureException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testCreate_withResults_Success() {

		$this->microDateTimeHelper->expectsIsBefore_Success(true, $this->microDateTimeMock);

		$microDateTimeClosure = new ConcreteMicroDateTimeClosure($this->closure, $this->microDateTimeMock, $this->microDateTimeMock, $this->results);

		$this->assertEquals($this->closure, $microDateTimeClosure->getClosure());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->startedOn());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->endsOn());
		$this->assertTrue($microDateTimeClosure->hasResults());
		$this->assertEquals($this->results, $microDateTimeClosure->getResults());

	}

	public function testCreate_withStringResults_Success() {

		$this->microDateTimeHelper->expectsIsBefore_Success(true, $this->microDateTimeMock);

		$microDateTimeClosure = new ConcreteMicroDateTimeClosure($this->closure, $this->microDateTimeMock, $this->microDateTimeMock, $this->stringResults);

		$this->assertEquals($this->closure, $microDateTimeClosure->getClosure());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->startedOn());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->endsOn());
		$this->assertTrue($microDateTimeClosure->hasResults());
		$this->assertEquals($this->stringResults, $microDateTimeClosure->getResults());

	}

	public function testCreate_withNullAsResults_Success() {

		$this->microDateTimeHelper->expectsIsBefore_Success(true, $this->microDateTimeMock);

		$microDateTimeClosure = new ConcreteMicroDateTimeClosure($this->closure, $this->microDateTimeMock, $this->microDateTimeMock, null);

		$this->assertEquals($this->closure, $microDateTimeClosure->getClosure());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->startedOn());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->endsOn());
		$this->assertFalse($microDateTimeClosure->hasResults());
		$this->assertNull($microDateTimeClosure->getResults());

	}

	public function testCreate_withEmptyResults_Success() {

		$this->microDateTimeHelper->expectsIsBefore_Success(true, $this->microDateTimeMock);

		$microDateTimeClosure = new ConcreteMicroDateTimeClosure($this->closure, $this->microDateTimeMock, $this->microDateTimeMock, []);

		$this->assertEquals($this->closure, $microDateTimeClosure->getClosure());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->startedOn());
		$this->assertEquals($this->microDateTimeMock, $microDateTimeClosure->endsOn());
		$this->assertFalse($microDateTimeClosure->hasResults());
		$this->assertNull($microDateTimeClosure->getResults());

	}

}
