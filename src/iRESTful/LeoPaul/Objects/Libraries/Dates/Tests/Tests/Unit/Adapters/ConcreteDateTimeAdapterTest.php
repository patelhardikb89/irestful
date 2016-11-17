<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Exceptions\DateTimeException;

final class ConcreteDateTimeAdapterTest extends \PHPUnit_Framework_TestCase {
    private $zone;
    private $timestamp;
    private $adapter;
    public function setUp() {

        $this->zone = 'America/Montreal';
        $this->timestamp = time();

        $this->adapter = new ConcreteDateTimeAdapter($this->zone);

    }

    public function tearDown() {

    }

    public function testFromTimestampToDateTime_Success() {

        $dateTime = $this->adapter->fromTimestampToDateTime($this->timestamp);

        $this->assertEquals($this->timestamp, $dateTime->getTimestamp());
        $this->assertEquals($this->zone, $dateTime->getTimezone()->getName());
    }

    public function testFromTimestampToDateTime_withNonTimestampString_throwsDateTimeException() {

        $asserted = false;
        try {

            $this->adapter->fromTimestampToDateTime('not a timestamp');

        } catch (DateTimeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withInvalidTimeZone_throwsDateTimeException() {

        $asserted = false;
        try {

            new ConcreteDateTimeAdapter('not a timezone');

        } catch (DateTimeException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
