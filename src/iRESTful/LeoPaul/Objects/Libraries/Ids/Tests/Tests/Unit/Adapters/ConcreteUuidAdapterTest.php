<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Adapters\ConcreteUuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Objects\ConcreteUuid;

final class ConcreteUuidAdapterTest extends \PHPUnit_Framework_TestCase {
    private $uuid;
    private $uuids;
    private $humanReadableUuid;
    private $humanReadableUuids;
    private $objects;
    private $adapter;
    public function setUp() {
        $this->humanReadableUuid = '633707d2-674d-4016-a6a1-e5213722907e';
        $this->humanReadableUuids = [
            $this->humanReadableUuid,
            '43040c6d-6a07-4d7e-9061-b7b94015a957'
        ];

        $this->uuid = hex2bin(str_replace('-', '', $this->humanReadableUuid));
        $this->uuids = [
            $this->uuid,
            hex2bin(str_replace('-', '', $this->humanReadableUuids[1]))
        ];

        $this->objects = [
            new ConcreteUuid($this->humanReadableUuids[0]),
            new ConcreteUuid($this->humanReadableUuids[1])
        ];

        $this->adapter = new ConcreteUuidAdapter();
    }

    public function tearDown() {

    }

    public function testFromStringToUuid_withBinaryString_Success() {

        $uuid = $this->adapter->fromStringToUuid($this->uuid);

        $this->assertEquals($this->humanReadableUuid, $uuid->getHumanReadable());
        $this->assertEquals($this->uuid, $uuid->get());

    }

    public function testFromStringToUuid_withHumanReadableString_Success() {

        $uuid = $this->adapter->fromStringToUuid($this->humanReadableUuid);

        $this->assertEquals($this->humanReadableUuid, $uuid->getHumanReadable());
        $this->assertEquals($this->uuid, $uuid->get());

    }

    public function testFromStringToUuid_withInvalidString_throwsUuidException() {

        $asserted = false;
        try {

            $this->adapter->fromStringToUuid('this is not a valid uuid');

        } catch (UuidException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromStringsToUuids_withBinaryStrings_Success() {

        $uuids = $this->adapter->fromStringsToUuids($this->uuids);

        $this->assertEquals(count($uuids), count($this->humanReadableUuids));
        $this->assertEquals(count($uuids), count($this->uuids));

        foreach($uuids as $index => $oneUuid) {
            $this->assertEquals($this->humanReadableUuids[$index], $oneUuid->getHumanReadable());
            $this->assertEquals($this->uuids[$index], $oneUuid->get());
        }
    }

    public function testFromStringsToUuids_withHumanReadableStrings_Success() {

        $uuids = $this->adapter->fromStringsToUuids($this->humanReadableUuids);

        $this->assertEquals(count($uuids), count($this->humanReadableUuids));
        $this->assertEquals(count($uuids), count($this->uuids));

        foreach($uuids as $index => $oneUuid) {
            $this->assertEquals($this->humanReadableUuids[$index], $oneUuid->getHumanReadable());
            $this->assertEquals($this->uuids[$index], $oneUuid->get());
        }
    }

    public function testFromStringsToUuids_withOneInvalidString_Success() {

        $asserted = false;
        try {

            $this->adapter->fromStringsToUuids([$this->uuid, 'this is not a valid uuid.']);

        } catch (UuidException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromHumanReadableStringToUuid_Success() {

        $uuid = $this->adapter->fromHumanReadableStringToUuid($this->humanReadableUuid);

        $this->assertEquals($this->humanReadableUuid, $uuid->getHumanReadable());
        $this->assertEquals($this->uuid, $uuid->get());

    }

    public function testFromHumanReadableStringToUuid_withInvalidHUmanReadableUuid_throwsUuidException() {

        $asserted = false;
        try {

            $this->adapter->fromHumanReadableStringToUuid('this is not a valid uuid.');

        } catch (UuidException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromHumanReadableStringsToUuids_Success() {

        $uuids = $this->adapter->fromHumanReadableStringsToUuids($this->humanReadableUuids);

        $this->assertEquals(count($uuids), count($this->humanReadableUuids));
        $this->assertEquals(count($uuids), count($this->uuids));

        foreach($uuids as $index => $oneUuid) {
            $this->assertEquals($this->humanReadableUuids[$index], $oneUuid->getHumanReadable());
            $this->assertEquals($this->uuids[$index], $oneUuid->get());
        }

    }

    public function testFromBinaryStringToUuid_Success() {

        $uuid = $this->adapter->fromBinaryStringToUuid($this->uuid);

        $this->assertEquals($this->humanReadableUuid, $uuid->getHumanReadable());
        $this->assertEquals($this->uuid, $uuid->get());

    }

    public function testFromBinaryStringToUuid_withInvalidUuid_throwsUuidException() {

        $asserted = false;
        try {

            $this->adapter->fromBinaryStringToUuid('080808');

        } catch (UuidException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromBinaryStringsToUuids_Success() {

        $uuids = $this->adapter->fromBinaryStringsToUuids($this->uuids);

        $this->assertEquals(count($uuids), count($this->humanReadableUuids));
        $this->assertEquals(count($uuids), count($this->uuids));

        foreach($uuids as $index => $oneUuid) {
            $this->assertEquals($this->humanReadableUuids[$index], $oneUuid->getHumanReadable());
            $this->assertEquals($this->uuids[$index], $oneUuid->get());
        }

    }

    public function testFromUuidsToBinaryStrings_Success() {

        $binaryUuids = $this->adapter->fromUuidsToBinaryStrings($this->objects);

        $this->assertEquals(count($binaryUuids), count($this->objects));

        foreach($binaryUuids as $index => $oneBinaryUuid) {
            $this->assertEquals($this->objects[$index]->get(), $oneBinaryUuid);
        }

    }

    public function testFromUuidsToHumanReadableStrings_Success() {

        $humanReadableUuids = $this->adapter->fromUuidsToHumanReadableStrings($this->objects);

        $this->assertEquals(count($humanReadableUuids), count($this->objects));

        foreach($humanReadableUuids as $index => $oneHumanReadableUuid) {
            $this->assertEquals($this->objects[$index]->getHumanReadable(), $oneHumanReadableUuid);
        }

    }

}
