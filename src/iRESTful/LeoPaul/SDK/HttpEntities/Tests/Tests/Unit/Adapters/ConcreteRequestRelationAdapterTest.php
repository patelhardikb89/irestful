<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteRequestRelationAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityRelationRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityRelationRetrieverCriteriaHelper;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Objects\UuidHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Relations\Exceptions\RequestRelationException;

final class ConcreteRequestRelationAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRetrieverCriteriaAdapterMock;
    private $entityRelationRetrieverCriteriaMock;
    private $uuidMock;
    private $port;
    private $headers;
    private $criteria;
    private $masterContainerName;
    private $slaveContainerName;
    private $slavePropertyName;
    private $masterUuid;
    private $httpRequestData;
    private $httpRequestDataWithPortHeaders;
    private $adapter;
    private $adapterWithPortHeaders;
    private $entityRelationRetrieverCriteriaAdapterHelper;
    private $entityRelationRetrieverCriteriaHelper;
    private $uuidHelper;
    public function setUp() {
        $this->entityRelationRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters\EntityRelationRetrieverCriteriaAdapter');
        $this->entityRelationRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

        $this->port = rand(1, 1000);
        $this->headers = [
            'some' => 'headers'
        ];

        $this->masterContainerName = 'roles';
        $this->slaveContainerName = 'permissions';
        $this->slavePropertyName = 'one_permission';
        $this->masterUuid = 'feda327a-3b3a-4283-a4b2-3b4b733142e1';

        $this->criteria = [
            'master_container' => $this->masterContainerName,
            'slave_container' => $this->slaveContainerName,
            'slave_property' => $this->slavePropertyName,
            'master_uuid' => $this->masterUuid
        ];

        $this->httpRequestData = [
            'uri' => '/'.$this->masterContainerName.'/'.$this->masterUuid.'/'.$this->slavePropertyName.'/'.$this->slaveContainerName,
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->httpRequestDataWithPortHeaders = [
            'uri' => '/'.$this->masterContainerName.'/'.$this->masterUuid.'/'.$this->slavePropertyName.'/'.$this->slaveContainerName,
            'method' => 'get',
            'port' => $this->port,
            'headers' => $this->headers
        ];

        $this->adapter = new ConcreteRequestRelationAdapter($this->entityRelationRetrieverCriteriaAdapterMock);
        $this->adapterWithPortHeaders = new ConcreteRequestRelationAdapter($this->entityRelationRetrieverCriteriaAdapterMock, $this->port, $this->headers);

        $this->entityRelationRetrieverCriteriaAdapterHelper = new EntityRelationRetrieverCriteriaAdapterHelper($this, $this->entityRelationRetrieverCriteriaAdapterMock);
        $this->entityRelationRetrieverCriteriaHelper = new EntityRelationRetrieverCriteriaHelper($this, $this->entityRelationRetrieverCriteriaMock);
        $this->uuidHelper = new UuidHelper($this, $this->uuidMock);
    }

    public function tearDown() {

    }

    public function testFromEntityRelationRetrieverCriteriaToHttpRequestData_Success() {

        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterContainerName_Success($this->masterContainerName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetSlaveContainerName_Success($this->slaveContainerName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetSlavePropertyName_Success($this->slavePropertyName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->masterUuid);

        $httpRequest = $this->adapter->fromEntityRelationRetrieverCriteriaToHttpRequestData($this->entityRelationRetrieverCriteriaMock);

        $this->assertEquals($this->httpRequestData, $httpRequest);

    }

    public function testFromEntityRelationRetrieverCriteriaToHttpRequestData_withPortHeaders_Success() {

        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterContainerName_Success($this->masterContainerName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetSlaveContainerName_Success($this->slaveContainerName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetSlavePropertyName_Success($this->slavePropertyName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->masterUuid);

        $httpRequest = $this->adapterWithPortHeaders->fromEntityRelationRetrieverCriteriaToHttpRequestData($this->entityRelationRetrieverCriteriaMock);

        $this->assertEquals($this->httpRequestDataWithPortHeaders, $httpRequest);

    }

    public function testFromDataToEntityRelationHttpRequestData_Success() {

        $this->entityRelationRetrieverCriteriaAdapterHelper->expectsFromDataToEntityRelationRetrieverCriteria_Success($this->entityRelationRetrieverCriteriaMock, $this->criteria);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterContainerName_Success($this->masterContainerName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetSlaveContainerName_Success($this->slaveContainerName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetSlavePropertyName_Success($this->slavePropertyName);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->masterUuid);

        $httpRequest = $this->adapter->fromDataToEntityRelationHttpRequestData($this->criteria);

        $this->assertEquals($this->httpRequestData, $httpRequest);

    }

    public function testFromDataToEntityRelationHttpRequestData_throwsEntityRelationException_throwsRequestRelationException() {

        $this->entityRelationRetrieverCriteriaAdapterHelper->expectsFromDataToEntityRelationRetrieverCriteria_throwsEntityRelationException($this->criteria);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRelationHttpRequestData($this->criteria);

        } catch (RequestRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
