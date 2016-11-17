<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Objects\UuidHelper;

final class UuidHelperTest extends \PHPUnit_Framework_TestCase {
	private $uuidMock;
	private $uuidMocks;
	private $uuid;
	private $uuids;
	private $humanReadableUuid;
	private $humanReadableUuids;
	private $helper;
	public function setUp() {

		$this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
		$this->uuidMocks = [
			$this->uuidMock,
			$this->uuidMock,
			$this->uuidMock,
			$this->uuidMock
		];

		$this->humanReadableUuid = '633707d2-674d-4016-a6a1-e5213722907e';
		$this->humanReadableUuids = [
			$this->humanReadableUuid,
			'62307e46-7795-4c61-9710-8ebdfff35438',
			'a8353357-9ec9-435f-a65b-0dbdc89156ed',
			'3060f384-9885-48f3-bd3f-78ac0dd5bb15'
		];

        $this->uuid = hex2bin(str_replace('-', '', $this->humanReadableUuid));
		$this->uuids = [
			$this->uuid,
			hex2bin(str_replace('-', '', $this->humanReadableUuids[1])),
			hex2bin(str_replace('-', '', $this->humanReadableUuids[2])),
			hex2bin(str_replace('-', '', $this->humanReadableUuids[3]))
		];

		$this->helper = new UuidHelper($this, $this->uuidMock);
	}

	public function tearDown() {

	}

	public function testGetHumanReadable_Success() {

		$this->helper->expectsGetHumanReadable_Success($this->humanReadableUuid);

		$humanReadableUuid = $this->uuidMock->getHumanReadable();

		$this->assertEquals($this->humanReadableUuid, $humanReadableUuid);

	}

	public function testGetHumanReadable_multiple_Success() {

		$this->helper->expectsGetHumanReadable_multiple_Success($this->humanReadableUuids);

		foreach($this->uuidMocks as $index => $oneUuidMock) {
			$humanReadableUuid = $oneUuidMock->getHumanReadable();
			$this->assertEquals($this->humanReadableUuids[$index], $humanReadableUuid);
		}

	}

	public function testGet_Success() {

		$this->helper->expectsGet_Success($this->uuid);

		$uuid = $this->uuidMock->get();

		$this->assertEquals($this->uuid, $uuid);

	}

	public function testGet_multiple_Success() {

		$this->helper->expectsGet_multiple_Success($this->uuids);

		foreach($this->uuidMocks as $index => $oneUuidMock) {
			$uuid = $oneUuidMock->get();
			$this->assertEquals($this->uuids[$index], $uuid);
		}

	}

}
