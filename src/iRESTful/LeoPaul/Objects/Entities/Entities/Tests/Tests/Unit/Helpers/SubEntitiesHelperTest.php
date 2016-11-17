<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\SubEntitiesHelper;

final class SubEntitiesHelperTest extends \PHPUnit_Framework_TestCase {
    private $subEntitiesMock;
    private $entityMock;
    private $entities;
    private $helper;
    public function setUp() {
        $this->subEntitiesMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->helper = new SubEntitiesHelper($this, $this->subEntitiesMock);
    }

    public function tearDown() {

    }

    public function testHasExistingEntities_Success() {

        $this->helper->expectsHasExistingEntities_Success(true);

        $hasEntities = $this->subEntitiesMock->hasExistingEntities();

        $this->assertTrue($hasEntities);

    }

    public function testGetExistingEntities_Success() {

        $this->helper->expectsGetExistingEntities_Success($this->entities);

        $entities = $this->subEntitiesMock->getExistingEntities();

        $this->assertEquals($this->entities, $entities);

    }

    public function testGetNewEntities_Success() {

        $this->helper->expectsGetNewEntities_Success($this->entities);

        $entities = $this->subEntitiesMock->getNewEntities();

        $this->assertEquals($this->entities, $entities);

    }

    public function testHasNewEntities_Success() {

        $this->helper->expectsHasNewEntities_Success(true);

        $hasEntities = $this->subEntitiesMock->hasNewEntities();

        $this->assertTrue($hasEntities);

    }

    public function testMerge_Success() {

        $this->helper->expectsMerge_Success($this->subEntitiesMock, $this->subEntitiesMock);

        $subEntities = $this->subEntitiesMock->merge($this->subEntitiesMock);

        $this->assertEquals($this->subEntitiesMock, $subEntities);

    }

    public function testDelete_Success() {

        $this->helper->expectsDelete_Success($this->subEntitiesMock, $this->subEntitiesMock);

        $subEntities = $this->subEntitiesMock->delete($this->subEntitiesMock);

        $this->assertEquals($this->subEntitiesMock, $subEntities);

    }

}
