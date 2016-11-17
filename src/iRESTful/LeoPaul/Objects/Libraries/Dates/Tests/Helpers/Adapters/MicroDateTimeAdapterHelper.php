<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Adapters\MicroDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Exceptions\MicroDateTimeException;

final class MicroDateTimeAdapterHelper {
	private $phpunit;
	private $microDateTimeAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, MicroDateTimeAdapter $microDateTimeAdapterMock) {
		$this->phpunit = $phpunit;
		$this->microDateTimeAdapterMock = $microDateTimeAdapterMock;
	}

	public function expectsFromStringToMicroDateTime_withAnyString_Success(MicroDateTime $returnedMicroDateTime) {
		$this->microDateTimeAdapterMock->expects($this->phpunit->once())
										->method('fromStringToMicroDateTime')
										->with($this->phpunit->isType('string'))
										->will($this->phpunit->returnValue($returnedMicroDateTime));
	}

	public function expectsFromStringToMicroDateTime_withAnyString_throwsMicroDateTimeException() {
		$this->microDateTimeAdapterMock->expects($this->phpunit->once())
										->method('fromStringToMicroDateTime')
										->with($this->phpunit->isType('string'))
										->will($this->phpunit->throwException(new MicroDateTimeException('TEST')));
	}

}
