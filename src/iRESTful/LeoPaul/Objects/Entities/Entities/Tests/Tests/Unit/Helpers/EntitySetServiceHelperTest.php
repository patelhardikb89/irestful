<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Services\EntitySetServiceHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetServiceHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityServiceMock;
    private $entityMock;
    private $entities;
    private $helper;
    public function setUp() {

        $this->entityServiceMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\EntitySetService');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->helper = new EntitySetServiceHelper($this, $this->entityServiceMock);

    }

    public function tearDown() {

    }

    public function testInsert_Success() {

        $this->helper->expectsInsert_Success($this->entities);

        $this->entityServiceMock->insert($this->entities);

    }

    public function testInsert_throwsEntitySetException() {

        $this->helper->expectsInsert_throwsEntitySetException($this->entities);

        $asserted = false;
        try {

            $this->entityServiceMock->insert($this->entities);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testUpdate_Success() {

        $this->helper->expectsUpdate_Success($this->entities, $this->entities);

        $this->entityServiceMock->update($this->entities, $this->entities);

    }

    public function testUpdate_throwsEntitySetException() {

        $this->helper->expectsUpdate_throwsEntitySetException($this->entities, $this->entities);

        $asserted = false;
        try {

            $this->entityServiceMock->update($this->entities, $this->entities);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testDelete_Success() {

        $this->helper->expectsDelete_Success($this->entities);

        $this->entityServiceMock->delete($this->entities);

    }

    public function testDelete_throwsEntitySetException() {

        $this->helper->expectsDelete_throwsEntitySetException($this->entities);

        $asserted = false;
        try {

            $this->entityServiceMock->delete($this->entities);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
