<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityRetrieverCriteriaHelper;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Objects\UuidHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\KeynameHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Exceptions\RequestException;

final class ConcreteRequestAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityRetrieverCriteriaAdapterMock;
    private $entityRetrieverCriteriaMock;
    private $uuidAdapterMock;
    private $uuidMock;
    private $keynameMock;
    private $criteria;
    private $containerName;
    private $uuid;
    private $uuids;
    private $uuidsData;
    private $firstKeynameName;
    private $firstKeynameValue;
    private $secondKeynameName;
    private $secondKeynameValue;
    private $keynames;
    private $uuidRequest;
    private $keynameRequest;
    private $keynamesRequest;
    private $adapter;
    private $entityRetrieverCriteriaAdapterHelper;
    private $entityRetrieverCriteriaHelper;
    private $entityPartialSetRetrieverCriteriaAdapterHelper;
    private $entityPartialSetRetrieverCriteriaHelper;
    private $entityRelationRetrieverCriteriaAdapterHelper;
    private $entityRelationRetrieverCriteriaHelper;
    private $uuidHelper;
    private $keynameHelper;
    public function setUp() {

        $this->entityRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters\EntityRetrieverCriteriaAdapter');
        $this->entityRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria');
        $this->uuidAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');

        $this->criteria = [
            'container' => 'my_container',
            'uuid' => '2819b42f-efd3-4a9a-a73f-4705bbf3ac1b'
        ];

        $this->containerName = 'my_container';

        $this->uuid = hex2bin(str_replace('-', '', '2819b42f-efd3-4a9a-a73f-4705bbf3ac1b'));

        $this->uuids = [
            $this->uuid,
            hex2bin(str_replace('-', '', '40988d18-9d7d-4133-a3a3-77d16c1837b7'))
        ];

        $this->uuidsData = [
            $this->uuidMock,
            $this->uuidMock
        ];

        $this->firstKeynameName = 'slug';
        $this->firstKeynameValue = 'this-is-a-slug';

        $this->secondKeynameName = 'name';
        $this->secondKeynameValue = 'myname';

        $this->keynames = [
            $this->keynameMock,
            $this->keynameMock
        ];

        $this->uuidRequest = [
            'query' => 'select * from '.$this->containerName.' where uuid = :uuid limit 0,1;',
            'params' => ['uuid' => $this->uuid]
        ];

        $this->keynameRequest = [
            'query' => 'select * from '.$this->containerName.' where '.$this->firstKeynameName.' = :'.$this->firstKeynameName.' limit 0,1;',
            'params' => [
                $this->firstKeynameName => $this->firstKeynameValue
            ]
        ];

        $this->keynamesRequest = [
            'query' => 'select * from '.$this->containerName.' where '.$this->firstKeynameName.' = :'.$this->firstKeynameName.' and '.$this->secondKeynameName.' = :'.$this->secondKeynameName.' limit 0,1;',
            'params' => [
                $this->firstKeynameName => $this->firstKeynameValue,
                $this->secondKeynameName => $this->secondKeynameValue
            ]
        ];

        $this->adapter = new ConcreteRequestAdapter($this->entityRetrieverCriteriaAdapterMock, $this->uuidAdapterMock);

        $this->entityRetrieverCriteriaAdapterHelper = new EntityRetrieverCriteriaAdapterHelper($this, $this->entityRetrieverCriteriaAdapterMock);
        $this->entityRetrieverCriteriaHelper = new EntityRetrieverCriteriaHelper($this, $this->entityRetrieverCriteriaMock);
        $this->uuidHelper = new UuidHelper($this, $this->uuidMock);
        $this->keynameHelper = new KeynameHelper($this, $this->keynameMock);

    }

    public function tearDown() {

    }

    public function testFromDataToEntityRequest_Success() {

        $this->entityRetrieverCriteriaAdapterHelper->expectsFromDataToRetrieverCriteria_Success($this->entityRetrieverCriteriaMock, $this->criteria);
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->uuid);

        $request = $this->adapter->fromDataToEntityRequest($this->criteria);

        $this->assertEquals($this->uuidRequest, $request);
    }

    public function testFromDataToEntityRequest_throwsEntityException_throwsRequestException() {

        $this->entityRetrieverCriteriaAdapterHelper->expectsFromDataToRetrieverCriteria_throwsEntityException($this->criteria);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityRequest($this->criteria);

        } catch (RequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromEntityRetrieverCriteriaToRequest_hasUuid_Success() {

        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->uuid);

        $request = $this->adapter->fromEntityRetrieverCriteriaToRequest($this->entityRetrieverCriteriaMock);

        $this->assertEquals($this->uuidRequest, $request);

    }

    public function testFromEntityRetrieverCriteriaToRequest_hasKeynames_Success() {

        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeynames_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetKeynames_Success($this->keynames);
        $this->keynameHelper->expectsGetName_multiple_Success([$this->firstKeynameName, $this->secondKeynameName]);
        $this->keynameHelper->expectsGetValue_multiple_Success([$this->firstKeynameValue, $this->secondKeynameValue]);

        $request = $this->adapter->fromEntityRetrieverCriteriaToRequest($this->entityRetrieverCriteriaMock);

        $this->assertEquals($this->keynamesRequest, $request);

    }

    public function testFromEntityRetrieverCriteriaToRequest_hasKeyname_Success() {

        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeynames_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeyname_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetKeyname_Success($this->keynameMock);
        $this->keynameHelper->expectsGetName_Success($this->firstKeynameName);
        $this->keynameHelper->expectsGetValue_Success($this->firstKeynameValue);

        $request = $this->adapter->fromEntityRetrieverCriteriaToRequest($this->entityRetrieverCriteriaMock);

        $this->assertEquals($this->keynameRequest, $request);

    }

    public function testFromEntityRetrieverCriteriaToRequest_withoutCriteria_throwsRequestException() {

        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeynames_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeyname_Success(false);

        $asserted = false;
        try {

            $this->adapter->fromEntityRetrieverCriteriaToRequest($this->entityRetrieverCriteriaMock);

        } catch (RequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
