<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityRelationRetrieverCriteriaHelper;

final class EntityRelationRetrieverCriteriaHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRetrieverCriteriaMock;
    private $uuidMock;
    private $masterContainerName;
    private $slaveContainerName;
    private $slavePropertyName;
    private $helper;
    public function setUp() {
        $this->entityRelationRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

        $this->masterContainerName = 'roles';
        $this->slaveContainerName = 'permissions';
        $this->slavePropertyName = 'permission';

        $this->helper = new EntityRelationRetrieverCriteriaHelper($this, $this->entityRelationRetrieverCriteriaMock);

    }

    public function tearDown() {

    }

    public function testGetMasterContainerName_Success() {

        $this->helper->expectsGetMasterContainerName_Success($this->masterContainerName);

        $masterContainerName = $this->entityRelationRetrieverCriteriaMock->getMasterContainerName();

        $this->assertEquals($this->masterContainerName, $masterContainerName);

    }

    public function testGetSlaveContainerName_Success() {

        $this->helper->expectsGetSlaveContainerName_Success($this->slaveContainerName);

        $slaveContainerName = $this->entityRelationRetrieverCriteriaMock->getSlaveContainerName();

        $this->assertEquals($this->slaveContainerName, $slaveContainerName);

    }

    public function testGetSlavePropertyName_Success() {

        $this->helper->expectsGetSlavePropertyName_Success($this->slavePropertyName);

        $slavePropertyName = $this->entityRelationRetrieverCriteriaMock->getSlavePropertyName();

        $this->assertEquals($this->slavePropertyName, $slavePropertyName);

    }

    public function testGetMasterUuid_Success() {

        $this->helper->expectsGetMasterUuid_Success($this->uuidMock);

        $masterUuid = $this->entityRelationRetrieverCriteriaMock->getMasterUuid();

        $this->assertEquals($this->uuidMock, $masterUuid);

    }

}
