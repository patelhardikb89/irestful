<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntitySetRetrieverCriteriaHelper;

final class EntitySetRetrieverCriteriaHelperTest extends \PHPUnit_Framework_TestCase {
    private $entitySetRetrieverCriteriaMock;
    private $keynameMock;
    private $uuidMock;
    private $orderingMock;
    private $containerName;
    private $uuids;
    private $helper;
    public function setUp() {
        $this->entitySetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria');
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');

        $this->containerName = 'my_container';
        $this->uuids = [
            $this->uuidMock,
            $this->uuidMock
        ];

        $this->helper = new EntitySetRetrieverCriteriaHelper($this, $this->entitySetRetrieverCriteriaMock);
    }

    public function tearDown() {

    }

    public function testGetContainerName_Success() {

        $this->helper->expectsGetContainerName_Success($this->containerName);

        $containerName = $this->entitySetRetrieverCriteriaMock->getContainerName();

        $this->assertEquals($this->containerName, $containerName);

    }

    public function testHasKeyname_Success() {

        $this->helper->expectsHasKeyname_Success(true);

        $hasKeyname = $this->entitySetRetrieverCriteriaMock->hasKeyname();

        $this->assertTrue($hasKeyname);

    }

    public function testGetKeyname_Success() {

        $this->helper->expectsGetKeyname_Success($this->keynameMock);

        $keyname = $this->entitySetRetrieverCriteriaMock->getKeyname();

        $this->assertEquals($this->keynameMock, $keyname);

    }

    public function testHasUuids_Success() {

        $this->helper->expectsHasUuids_Success(true);

        $hasUuids = $this->entitySetRetrieverCriteriaMock->hasUuids();

        $this->assertTrue($hasUuids);

    }

    public function testGetUuids_Success() {

        $this->helper->expectsGetUuids_Success($this->uuids);

        $uuids = $this->entitySetRetrieverCriteriaMock->getUuids();

        $this->assertEquals($this->uuids, $uuids);

    }

    public function testHasOrdering_Success() {

        $this->helper->expectsHasOrdering_Success(true);

        $hasOrdering = $this->entitySetRetrieverCriteriaMock->hasOrdering();

        $this->assertTrue($hasOrdering);

    }

    public function testGetOrdering_Success() {

        $this->helper->expectsGetOrdering_Success($this->orderingMock);

        $ordering = $this->entitySetRetrieverCriteriaMock->getOrdering();

        $this->assertEquals($this->orderingMock, $ordering);

    }

}
