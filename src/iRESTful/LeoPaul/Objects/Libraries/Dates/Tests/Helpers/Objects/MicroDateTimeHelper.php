<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime;

final class MicroDateTimeHelper {
	private $phpunit;
	private $microDateTimeMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, MicroDateTime $microDateTimeMock) {
		$this->phpunit = $phpunit;
		$this->microDateTimeMock = $microDateTimeMock;
	}

	public function expectsGetDateTime_Success(\DateTime $returnedDateTime) {
		$this->microDateTimeMock->expects($this->phpunit->once())
									->method('getDateTime')
									->will($this->phpunit->returnValue($returnedDateTime));
	}

	public function expectsGetMicroSeconds_Success($returnedMicroSeconds) {
		$this->microDateTimeMock->expects($this->phpunit->once())
									->method('getMicroSeconds')
									->will($this->phpunit->returnValue($returnedMicroSeconds));
	}

	public function expectsIsBefore_Success($returnedBoolean, MicroDateTime $microDateTime) {
		$this->microDateTimeMock->expects($this->phpunit->once())
									->method('isBefore')
									->with($microDateTime)
									->will($this->phpunit->returnValue($returnedBoolean));
	}

}
