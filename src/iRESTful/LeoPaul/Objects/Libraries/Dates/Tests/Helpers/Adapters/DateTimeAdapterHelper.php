<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Exceptions\DateTimeException;

final class DateTimeAdapterHelper {
    private $phpunit;
    private $dateTimeAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, DateTimeAdapter $dateTimeAdapterMock) {
        $this->phpunit = $phpunit;
        $this->dateTimeAdapterMock = $dateTimeAdapterMock;
    }

    public function expectsFromTimestampToDateTime_Success(\DateTime $returnedDateTime, $timestamp) {

        $this->dateTimeAdapterMock->expects($this->phpunit->once())
                                    ->method('fromTimestampToDateTime')
                                    ->with($timestamp)
                                    ->will($this->phpunit->returnValue($returnedDateTime));

    }

    public function expectsFromTimestampToDateTime_throwsDateTimeException($timestamp) {

        $this->dateTimeAdapterMock->expects($this->phpunit->once())
                                    ->method('fromTimestampToDateTime')
                                    ->with($timestamp)
                                    ->will($this->phpunit->throwException(new DateTimeException('TEST')));

    }

}
