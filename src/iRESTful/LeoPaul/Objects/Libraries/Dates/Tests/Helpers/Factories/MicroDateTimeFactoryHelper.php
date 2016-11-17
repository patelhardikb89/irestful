<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Factories\MicroDateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\MicroDateTime;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Exceptions\MicroDateTimeException;

final class MicroDateTimeFactoryHelper {
	private $phpunit;
	private $microDateTimeFactoryMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, MicroDateTimeFactory $microDateTimeFactoryMock) {
		$this->phpunit = $phpunit;
		$this->microDateTimeFactoryMock = $microDateTimeFactoryMock;
	}

	public function expectsCreate_Success(MicroDateTime $returnedMicroDateTime) {
		$this->microDateTimeFactoryMock->expects($this->phpunit->once())
										->method('create')
										->will($this->phpunit->returnValue($returnedMicroDateTime));

	}

	public function expectsCreate_throwsMicroDateTimeException() {
		$this->microDateTimeFactoryMock->expects($this->phpunit->once())
										->method('create')
										->will($this->phpunit->throwException(new MicroDateTimeException('TEST')));

	}

	public function expectsCreate_multiple_Success(array $returnedMicroDateTimes) {

		foreach($returnedMicroDateTimes as $index => $oneMicroDateTime) {
			$this->microDateTimeFactoryMock->expects($this->phpunit->at($index))
											->method('create')
											->will($this->phpunit->returnValue($oneMicroDateTime));
		}

	}

}
