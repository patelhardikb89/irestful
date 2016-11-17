<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Services\EntityServiceHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityServiceHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityServiceMock;
    private $entityMock;
    private $helper;
    public function setUp() {
        $this->entityServiceMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->helper = new EntityServiceHelper($this, $this->entityServiceMock );
    }

    public function tearDown() {

    }

    public function testInsert_Success() {

        $this->helper->expectsInsert_Success($this->entityMock);

        $this->entityServiceMock->insert($this->entityMock);

    }

    public function testInsert_throwsEntityException() {

        $this->helper->expectsInsert_throwsEntityException($this->entityMock);

        $asserted = true;
        try {

            $this->entityServiceMock->insert($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testUpdate_Success() {

        $this->helper->expectsUpdate_Success($this->entityMock, $this->entityMock);

        $this->entityServiceMock->update($this->entityMock, $this->entityMock);

    }

    public function testUpdate_throwsEntityException() {

        $this->helper->expectsUpdate_throwsEntityException($this->entityMock, $this->entityMock);

        $asserted = true;
        try {

            $this->entityServiceMock->update($this->entityMock, $this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testDelete_Success() {

        $this->helper->expectsDelete_Success($this->entityMock);

        $this->entityServiceMock->delete($this->entityMock);

    }

    public function testDelete_throwsEntityException() {

        $this->helper->expectsDelete_throwsEntityException($this->entityMock);

        $asserted = true;
        try {

            $this->entityServiceMock->delete($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
