<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Factories\DateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Exceptions\DateTimeException;

final class DateTimeFactoryHelper {
	private $phpunit;
	private $factoryMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, DateTimeFactory $factoryMock) {
		$this->phpunit = $phpunit;
		$this->factoryMock = $factoryMock;
	}

	public function expectsCreate_Success(\DateTime $returnedDateTime) {
		$this->factoryMock->expects($this->phpunit->once())
							->method('create')
							->will($this->phpunit->returnValue($returnedDateTime));
	}

    public function expectsCreate_multiple_Success(array $returnedDateTimes) {
		foreach($returnedDateTimes as $index => $oneDateTime) {
            $this->factoryMock->expects($this->phpunit->at($index))
                                ->method('create')
                                ->will($this->phpunit->returnValue($oneDateTime));
        }
	}

	public function expectsCreate_throwsDateTimeException() {
		$this->factoryMock->expects($this->phpunit->once())
							->method('create')
							->will($this->phpunit->throwException(new DateTimeException('TEST')));
	}

}
