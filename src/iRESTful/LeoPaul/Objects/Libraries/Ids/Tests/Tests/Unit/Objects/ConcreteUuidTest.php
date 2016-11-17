<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Objects\ConcreteUuid;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;

final class ConcreteUuidTest extends \PHPUnit_Framework_TestCase {
    private $uuid;
    private $humanReadableUuid;
    public function setUp() {
        $this->humanReadableUuid = '633707d2-674d-4016-a6a1-e5213722907e';
        $this->uuid = hex2bin(str_replace('-', '', $this->humanReadableUuid));
    }

    public function tearDown() {

    }

    public function testCreate_withHumanReadableUuid_Success() {

        $uuid = new ConcreteUuid($this->humanReadableUuid);

        $this->assertEquals($this->humanReadableUuid, $uuid->getHumanReadable());
        $this->assertEquals($this->uuid, $uuid->get());

    }

    public function testCreate_withUuid_Success() {

        $uuid = new ConcreteUuid(null, $this->uuid);

        $this->assertEquals($this->humanReadableUuid, $uuid->getHumanReadable());
        $this->assertEquals($this->uuid, $uuid->get());

    }

    public function testCreate_withBothUuids_throwsUuidException() {

        $asserted = false;
        try {

            new ConcreteUuid($this->humanReadableUuid, $this->uuid);

        } catch (UuidException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withoutUuids_throwsUuidException() {

        $asserted = false;
        try {

            new ConcreteUuid();

        } catch (UuidException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidHumanReadableUuid_throwsUuidException() {

        $asserted = false;
        try {

            new ConcreteUuid('this is not a valid human readable uuid.');

        } catch (UuidException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidUuid_throwsUuidException() {

        $asserted = false;
        try {

            new ConcreteUuid(null, hex2bin('080808'));

        } catch (UuidException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
