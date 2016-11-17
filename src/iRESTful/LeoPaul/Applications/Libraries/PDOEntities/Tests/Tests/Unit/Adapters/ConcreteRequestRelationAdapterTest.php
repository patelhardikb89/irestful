<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestRelationAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Objects\UuidHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Exceptions\RequestRelationException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityRelationRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityRelationRetrieverCriteriaHelper;

final class ConcreteRequestRelationAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRetrieverCriteriaAdapterMock;
    private $entityRelationRetrieverCriteriaMock;
    private $uuidMock;
    private $criteria;
    private $masterContainerName;
    private $slaveContainerName;
    private $slavePropertyName;
    private $uuid;
    private $adapter;
    private $entityRelationRetrieverCriteriaAdapterHelper;
    private $entityRelationRetrieverCriteriaHelper;
    private $entityAdapterHelper;
    private $uuidHelper;
    public function setUp() {
        $this->entityRelationRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters\EntityRelationRetrieverCriteriaAdapter');
        $this->entityRelationRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

        $this->masterContainerName = 'roles';
        $this->slaveContainerName = 'permissions';
        $this->slavePropertyName = 'permission';
        $this->uuid = '40988d18-9d7d-4133-a3a3-77d16c1837b7';

        $this->criteria = [
            'master_container' => $this->masterContainerName,
            'slave_container' => $this->slaveContainerName,
            'slave_property' => $this->slavePropertyName,
            'master_uuid' => $this->uuid
        ];

        $this->adapter = new ConcreteRequestRelationAdapter($this->entityRelationRetrieverCriteriaAdapterMock);

        $this->entityRelationRetrieverCriteriaAdapterHelper = new EntityRelationRetrieverCriteriaAdapterHelper($this, $this->entityRelationRetrieverCriteriaAdapterMock);
        $this->entityRelationRetrieverCriteriaHelper = new EntityRelationRetrieverCriteriaHelper($this, $this->entityRelationRetrieverCriteriaMock);
        $this->uuidHelper = new UuidHelper($this, $this->uuidMock);

    }

    public function tearDown() {

    }

    public function testFromEntityRelationRetrieverCriteriaToRequest_Success() {
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterContainerName_Success($this->masterContainerName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetSlaveContainerName_Success($this->slaveContainerName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetSlavePropertyName_Success($this->slavePropertyName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->uuid);

        $request = $this->adapter->fromEntityRelationRetrieverCriteriaToRequest($this->entityRelationRetrieverCriteriaMock);

        $table = $this->masterContainerName.'___'.$this->slavePropertyName;
        $query = '
                    select '.$this->slaveContainerName.'.* from '.$table.'
                    inner join '.$this->slaveContainerName.' on '.$table.'.slave_uuid = '.$this->slaveContainerName.'.uuid
                    where '.$table.'.master_uuid = :master_uuid;
        ';

        $this->assertEquals([
            'query' => $query,
            'params' => ['master_uuid' => $this->uuid]
        ], $request);
    }

    public function testFromDataToEntityRelationRequest_Success() {
        $this->entityRelationRetrieverCriteriaAdapterHelper->expectsFromDataToEntityRelationRetrieverCriteria_Success($this->entityRelationRetrieverCriteriaMock, $this->criteria);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterContainerName_Success($this->masterContainerName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetSlaveContainerName_Success($this->slaveContainerName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetSlavePropertyName_Success($this->slavePropertyName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->uuid);

        $request = $this->adapter->fromDataToEntityRelationRequest($this->criteria);

        $table = $this->masterContainerName.'___'.$this->slavePropertyName;
        $query = '
                    select '.$this->slaveContainerName.'.* from '.$table.'
                    inner join '.$this->slaveContainerName.' on '.$table.'.slave_uuid = '.$this->slaveContainerName.'.uuid
                    where '.$table.'.master_uuid = :master_uuid;
        ';

        $this->assertEquals([
            'query' => $query,
            'params' => ['master_uuid' => $this->uuid]
        ], $request);
    }

    public function testFromDataToEntityRelationRequest_throwsEntityRelationException_throwsRequestRelationException() {
        $this->entityRelationRetrieverCriteriaAdapterHelper->expectsFromDataToEntityRelationRetrieverCriteria_throwsEntityRelationException($this->criteria);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationRequest($this->criteria);

        } catch (RequestRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
