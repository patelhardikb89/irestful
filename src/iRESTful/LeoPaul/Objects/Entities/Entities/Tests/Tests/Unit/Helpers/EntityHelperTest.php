<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityHelper;

final class EntityHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityMock;
    private $uuidMock;
    private $createdOn;
    private $helper;
    public function setUp() {
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

        $this->createdOn = new \DateTime();

        $this->helper = new EntityHelper($this, $this->entityMock);
    }

    public function tearDown() {

    }

    public function testGetUuid_Success() {

        $this->helper->expectsGetUuid_Success($this->uuidMock);

        $uuid = $this->entityMock->getUuid();

        $this->assertEquals($this->uuidMock, $uuid);

    }

    public function testGetUuid_multiple_Success() {

        $this->helper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock]);

        $firstUuid = $this->entityMock->getUuid();
        $secondUuid = $this->entityMock->getUuid();

        $this->assertEquals($this->uuidMock, $firstUuid);
        $this->assertEquals($this->uuidMock, $secondUuid);

    }

    public function testCreatedOn_Success() {

        $this->helper->expectsCreatedOn_Success($this->createdOn);

        $createdOn = $this->entityMock->createdOn();

        $this->assertEquals($this->createdOn, $createdOn);

    }

}
