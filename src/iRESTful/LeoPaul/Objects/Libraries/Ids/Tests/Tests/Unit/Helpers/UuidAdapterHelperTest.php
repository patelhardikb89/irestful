<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Adapters\UuidAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;

final class UuidAdapterHelperTest extends \PHPUnit_Framework_TestCase {
	private $uuidAdapterMock;
	private $uuidMock;
	private $uuidMocks;
	private $binaryUuid;
	private $binaryUuids;
	private $humanReadableUuid;
	private $humanReadableUuids;
	private $helper;
	public function setUp() {

		$this->uuidAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter');
		$this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
		$this->uuidMocks = [
			$this->uuidMock,
			$this->uuidMock,
			$this->uuidMock
		];

		$this->humanReadableUuid = '633707d2-674d-4016-a6a1-e5213722907e';
		$this->humanReadableUuids = [
			$this->humanReadableUuid,
			'3c51ce58-ca4e-4a3e-bcc7-1e0057db3903',
			'b54e3933-cb4a-46f8-813d-9221666070f2'
		];

		$this->binaryUuid = hex2bin(str_replace('-', '', $this->humanReadableUuid));
		$this->binaryUuids = [
			$this->binaryUuid,
			hex2bin(str_replace('-', '', $this->humanReadableUuids[1])),
			hex2bin(str_replace('-', '', $this->humanReadableUuids[2]))
		];

		$this->helper = new UuidAdapterHelper($this, $this->uuidAdapterMock);

	}

	public function tearDown() {

	}

	public function testFromStringToUuid_Success() {

		$this->helper->expectsFromStringToUuid_Success($this->uuidMock, $this->binaryUuid);

		$uuid = $this->uuidAdapterMock->fromStringToUuid($this->binaryUuid);

		$this->assertEquals($this->uuidMock, $uuid);

	}

	public function testFromStringToUuid_throwsUuidException() {

		$this->helper->expectsFromStringToUuid_throwsUuidException($this->binaryUuid);

		$asserted = false;
		try {

			$this->uuidAdapterMock->fromStringToUuid($this->binaryUuid);

		} catch (UuidException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromStringsToUuids_Success() {

		$this->helper->expectsFromStringsToUuids_Success($this->uuidMocks, $this->binaryUuids);

		$uuids = $this->uuidAdapterMock->fromStringsToUuids($this->binaryUuids);

		$this->assertEquals($this->uuidMocks, $uuids);

	}

	public function testFromStringsToUuids_throwsUuidException() {

		$this->helper->expectsFromStringsToUuids_throwsUuidException($this->binaryUuids);

		$asserted = false;
		try {

			$this->uuidAdapterMock->fromStringsToUuids($this->binaryUuids);

		} catch (UuidException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromHumanReadableStringToUuid_Success() {

		$this->helper->expectsFromHumanReadableStringToUuid_Success($this->uuidMock, $this->humanReadableUuid);

		$uuid = $this->uuidAdapterMock->fromHumanReadableStringToUuid($this->humanReadableUuid);

		$this->assertEquals($this->uuidMock, $uuid);

	}

	public function testFromHumanReadableStringToUuid_throwsUuidException() {

		$this->helper->expectsFromHumanReadableStringToUuid_throwsUuidException($this->humanReadableUuid);

		$asserted = false;
		try {

			$this->uuidAdapterMock->fromHumanReadableStringToUuid($this->humanReadableUuid);

		} catch (UuidException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromHumanReadableStringsToUuids_Success() {

		$this->helper->expectsFromHumanReadableStringsToUuids_Success($this->uuidMocks, $this->humanReadableUuids);

		$uuids = $this->uuidAdapterMock->fromHumanReadableStringsToUuids($this->humanReadableUuids);

		$this->assertEquals($this->uuidMocks, $uuids);

	}

	public function testFromHumanReadableStringsToUuids_throwsUuidException() {

		$this->helper->expectsFromHumanReadableStringsToUuids_throwsUuidException($this->humanReadableUuids);

		$asserted = false;
		try {

			$this->uuidAdapterMock->fromHumanReadableStringsToUuids($this->humanReadableUuids);

		} catch (UuidException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromBinaryStringToUuid_Success() {

		$this->helper->expectsFromBinaryStringToUuid_Success($this->uuidMock, $this->binaryUuid);

		$uuid = $this->uuidAdapterMock->fromBinaryStringToUuid($this->binaryUuid);

		$this->assertEquals($this->uuidMock, $uuid);

	}

	public function testFromBinaryStringToUuid_throwsUuidException() {

		$this->helper->expectsFromBinaryStringToUuid_throwsUuidException($this->binaryUuid);

		$asserted = false;
		try {

			$this->uuidAdapterMock->fromBinaryStringToUuid($this->binaryUuid);

		} catch (UuidException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromBinaryStringsToUuids_Success() {

		$this->helper->expectsFromBinaryStringsToUuids_Success($this->uuidMocks, $this->binaryUuids);

		$uuids = $this->uuidAdapterMock->fromBinaryStringsToUuids($this->binaryUuids);

		$this->assertEquals($this->uuidMocks, $uuids);

	}

	public function testFromBinaryStringsToUuids_throwsUuidException() {

		$this->helper->expectsFromBinaryStringsToUuids_throwsUuidException($this->binaryUuids);

		$asserted = false;
		try {

			$this->uuidAdapterMock->fromBinaryStringsToUuids($this->binaryUuids);

		} catch (UuidException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromUuidsToBinaryStrings_Success() {

		$this->helper->expectsFromUuidsToBinaryStrings_Success($this->binaryUuids, $this->uuidMocks);

		$binaryUuids = $this->uuidAdapterMock->fromUuidsToBinaryStrings($this->uuidMocks);

		$this->assertEquals($this->binaryUuids, $binaryUuids);

	}

	public function testFromUuidsToBinaryStrings_throwsUuidException() {

		$this->helper->expectsFromUuidsToBinaryStrings_throwsUuidException($this->uuidMocks);

		$asserted = false;
		try {

			$this->uuidAdapterMock->fromUuidsToBinaryStrings($this->uuidMocks);

		} catch (UuidException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

	public function testFromUuidsToHumanReadableStrings_Success() {

		$this->helper->expectsFromUuidsToHumanReadableStrings_Success($this->humanReadableUuids, $this->uuidMocks);

		$humanReadableUuids = $this->uuidAdapterMock->fromUuidsToHumanReadableStrings($this->uuidMocks);

		$this->assertEquals($this->humanReadableUuids, $humanReadableUuids);

	}

	public function testFromUuidsToHumanReadableStrings_throwsUuidException() {

		$this->helper->expectsFromUuidsToHumanReadableStrings_throwsUuidException($this->uuidMocks);

		$asserted = false;
		try {

			$this->uuidAdapterMock->fromUuidsToHumanReadableStrings($this->uuidMocks);

		} catch (UuidException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
