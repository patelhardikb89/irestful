<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Exceptions\DateTimeException;

final class ConcreteDateTimeAdapter implements DateTimeAdapter {
    private $timeZone;
    public function __construct($timeZone) {

        try {

            $this->timeZone = new \DateTimeZone($timeZone);

        } catch (\Exception $exception) {
            throw new DateTimeException('The given timezone ('.$timeZone.') is invalid.');
        }
    }

    public function fromTimestampToDateTime($timestamp) {

        try {

            $dateTime = new \DateTime();
            $dateTime->setTimeZone($this->timeZone)->setTimestamp($timestamp);
            return $dateTime;

        } catch (\Exception $exception) {
            throw new DateTimeException('There was an exception while creating a \DateTime object.', $exception);
        }
    }

}
