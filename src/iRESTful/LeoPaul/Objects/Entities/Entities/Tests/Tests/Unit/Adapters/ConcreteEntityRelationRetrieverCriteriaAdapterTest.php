<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityRelationRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Adapters\UuidAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class ConcreteEntityRelationRetrieverCriteriaAdapterTest extends \PHPUnit_Framework_TestCase {
    private $uuidAdapterMock;
    private $uuidMock;
    private $masterContainerName;
    private $slaveContainerName;
    private $slavePropertyName;
    private $masterUuid;
    private $data;
    private $adapter;
    private $uuidAdapterHelper;
    public function setUp() {

        $this->uuidAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

        $this->masterContainerName = 'roles';
        $this->slaveContainerName = 'permissions';
        $this->slavePropertyName = 'pernission';
        $this->masterUuid = '960eada9-1cef-489e-baee-51bd4b3c4cae';

        $this->data = [
            'master_container' => $this->masterContainerName,
            'slave_container' => $this->slaveContainerName,
            'slave_property' => $this->slavePropertyName,
            'master_uuid' => $this->masterUuid
        ];

        $this->adapter = new ConcreteEntityRelationRetrieverCriteriaAdapter($this->uuidAdapterMock);

        $this->uuidAdapterHelper = new UuidAdapterHelper($this, $this->uuidAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityRelationRetrieverCriteria_Success() {

        $this->uuidAdapterHelper->expectsFromStringToUuid_Success($this->uuidMock, $this->masterUuid);

        $criteria = $this->adapter->fromDataToEntityRelationRetrieverCriteria($this->data);

        $this->assertEquals($this->masterContainerName, $criteria->getMasterContainerName());
        $this->assertEquals($this->slaveContainerName, $criteria->getSlaveContainerName());
        $this->assertEquals($this->slavePropertyName, $criteria->getSlavePropertyName());
        $this->assertEquals($this->uuidMock, $criteria->getMasterUuid());

    }

    public function testFromDataToEntityRelationRetrieverCriteria_throwsUuidException_throwsEntityRelationException() {

        $this->uuidAdapterHelper->expectsFromStringToUuid_throwsUuidException($this->masterUuid);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRetrieverCriteria($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityRelationRetrieverCriteria_withoutMasterContainer_throwsEntityRelationException() {

        unset($this->data['master_container']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRetrieverCriteria($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityRelationRetrieverCriteria_withoutSlaveContainer_throwsEntityRelationException() {

        unset($this->data['slave_container']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRetrieverCriteria($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityRelationRetrieverCriteria_withoutSlaveProperty_throwsEntityRelationException() {

        unset($this->data['slave_property']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRetrieverCriteria($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityRelationRetrieverCriteria_withoutMasterUuid_throwsEntityRelationException() {

        unset($this->data['master_uuid']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRetrieverCriteria($this->data);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
