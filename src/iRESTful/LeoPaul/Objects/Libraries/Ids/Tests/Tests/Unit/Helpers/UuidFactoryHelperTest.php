<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Factories\UuidFactoryHelper;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;

final class UuidFactoryHelperTest extends \PHPUnit_Framework_TestCase {
	private $uuidMock;
	private $factoryMock;
	private $helper;
	public function setUp() {

		$this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
		$this->factory = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Factories\UuidFactory');

		$this->helper = new UuidFactoryHelper($this, $this->factory);
	}

	public function tearDown() {

	}

    public function testCreate_Success() {

		$this->helper->expectsCreate_Success($this->uuidMock);

		$uuid = $this->factory->create();

		$this->assertEquals($this->uuidMock, $uuid);

	}

    public function testCreate_multiple_Success() {

		$this->helper->expectsCreate_multiple_Success([$this->uuidMock, $this->uuidMock]);

		$firstUuid = $this->factory->create();
        $secondUuid = $this->factory->create();

		$this->assertEquals($this->uuidMock, $firstUuid);
        $this->assertEquals($this->uuidMock, $secondUuid);

	}

	public function testCreate_throwsUuidException() {

		$this->helper->expectsCreate_throwsUuidException();

		$asserted = false;
		try {

			$this->factory->create();

		} catch (UuidException $exception) {
			$asserted = true;
		}

		$this->assertTrue($asserted);

	}

}
