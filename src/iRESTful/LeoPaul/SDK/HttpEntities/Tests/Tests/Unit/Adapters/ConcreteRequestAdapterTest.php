<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteRequestAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityRetrieverCriteriaHelper;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Objects\UuidHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\KeynameHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Exceptions\RequestException;

final class ConcreteRequestAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityRetrieverCriteriaAdapterMock;
    private $entityRetrieverCriteriaMock;
    private $uuidMock;
    private $keynameMock;
    private $containerName;
    private $port;
    private $headers;
    private $uuid;
    private $firstKeynameName;
    private $firstKeynameValue;
    private $secondKeynameName;
    private $secondKeynameValue;
    private $keynames;
    private $criteriaWithUuid;
    private $httpRequestDataWithUuid;
    private $httpRequestDataWithUuidWithPortHeaders;
    private $httpRequestDataWithKeyname;
    private $httpRequestDataWithKeynameWithPortHeaders;
    private $httpRequestDataWithKeynames;
    private $httpRequestDataWithKeynamesWithPortHeaders;
    private $adapter;
    private $adapterWithPortHeaders;
    private $entityRetrieverCriteriaAdapterHelper;
    private $entityRetrieverCriteriaHelper;
    private $uuidHelper;
    private $keynameHelper;
    public function setUp() {
        $this->entityRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters\EntityRetrieverCriteriaAdapter');
        $this->entityRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');

        $this->port = rand(1, 5000);
        $this->headers = [
            'additional' => 'headers'
        ];

        $this->containerName = 'my_container';
        $this->uuid = '2002bb0d-4fbe-4b07-bd12-e63d1a2b40af';

        $this->firstKeynameName = 'slug';
        $this->firstKeynameValue = 'my-slug';

        $this->secondKeynameName = 'id';
        $this->secondKeynameValue = 'koilPOI';

        $this->keynames = [
            $this->keynameMock,
            $this->keynameMock
        ];

        $this->criteriaWithUuid = [
            'container' => $this->containerName,
            'uuid' => $this->uuid
        ];

        $this->httpRequestDataWithUuid = [
            'uri' => '/'.$this->containerName.'/'.$this->uuid,
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->httpRequestDataWithUuidWithPortHeaders = [
            'uri' => '/'.$this->containerName.'/'.$this->uuid,
            'method' => 'get',
            'port' => $this->port,
            'headers' => $this->headers
        ];

        $this->httpRequestDataWithKeyname = [
            'uri' => '/'.$this->containerName.'/'.$this->firstKeynameName.'/'.$this->firstKeynameValue,
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->httpRequestDataWithKeynameWithPortHeaders  = [
            'uri' => '/'.$this->containerName.'/'.$this->firstKeynameName.'/'.$this->firstKeynameValue,
            'method' => 'get',
            'port' => $this->port,
            'headers' => $this->headers
        ];

        $this->httpRequestDataWithKeynames = [
            'uri' => '/'.$this->containerName.'/'.$this->firstKeynameName.','.$this->secondKeynameName.'/'.$this->firstKeynameValue.','.$this->secondKeynameValue,
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->httpRequestDataWithKeynamesWithPortHeaders = [
            'uri' => '/'.$this->containerName.'/'.$this->firstKeynameName.','.$this->secondKeynameName.'/'.$this->firstKeynameValue.','.$this->secondKeynameValue,
            'method' => 'get',
            'port' => $this->port,
            'headers' => $this->headers
        ];

        $this->adapter = new ConcreteRequestAdapter($this->entityRetrieverCriteriaAdapterMock);
        $this->adapterWithPortHeaders = new ConcreteRequestAdapter($this->entityRetrieverCriteriaAdapterMock, $this->port, $this->headers);

        $this->entityRetrieverCriteriaAdapterHelper = new EntityRetrieverCriteriaAdapterHelper($this, $this->entityRetrieverCriteriaAdapterMock);
        $this->entityRetrieverCriteriaHelper = new EntityRetrieverCriteriaHelper($this, $this->entityRetrieverCriteriaMock);
        $this->uuidHelper = new UuidHelper($this, $this->uuidMock);
        $this->keynameHelper = new KeynameHelper($this, $this->keynameMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityHttpRequestData_Success() {
        $this->entityRetrieverCriteriaAdapterHelper->expectsFromDataToRetrieverCriteria_Success($this->entityRetrieverCriteriaMock, $this->criteriaWithUuid);
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);

        $httpRequest = $this->adapter->fromDataToEntityHttpRequestData($this->criteriaWithUuid);

        $this->assertEquals($this->httpRequestDataWithUuid, $httpRequest);

    }

    public function testFromDataToEntityHttpRequestData_throwsEntityException_throwsRequestException() {
        $this->entityRetrieverCriteriaAdapterHelper->expectsFromDataToRetrieverCriteria_throwsEntityException($this->criteriaWithUuid);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityHttpRequestData($this->criteriaWithUuid);

        } catch (RequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityRetrieverCriteriaToHttpRequestData_withUuid_Success() {
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);

        $httpRequest = $this->adapter->fromEntityRetrieverCriteriaToHttpRequestData($this->entityRetrieverCriteriaMock);

        $this->assertEquals($this->httpRequestDataWithUuid, $httpRequest);

    }

    public function testFromEntityRetrieverCriteriaToHttpRequestData_withUuid_withPortHeaders_Success() {
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);

        $httpRequest = $this->adapterWithPortHeaders->fromEntityRetrieverCriteriaToHttpRequestData($this->entityRetrieverCriteriaMock);

        $this->assertEquals($this->httpRequestDataWithUuidWithPortHeaders, $httpRequest);

    }

    public function testFromEntityRetrieverCriteriaToHttpRequestData_withKeynames_Success() {
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeynames_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetKeynames_Success($this->keynames);
        $this->keynameHelper->expectsGetName_multiple_Success([$this->firstKeynameName, $this->secondKeynameName]);
        $this->keynameHelper->expectsGetValue_multiple_Success([$this->firstKeynameValue, $this->secondKeynameValue]);

        $httpRequest = $this->adapter->fromEntityRetrieverCriteriaToHttpRequestData($this->entityRetrieverCriteriaMock);

        $this->assertEquals($this->httpRequestDataWithKeynames, $httpRequest);

    }

    public function testFromEntityRetrieverCriteriaToHttpRequestData_withKeynames_withPortHeaders_Success() {
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeynames_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetKeynames_Success($this->keynames);
        $this->keynameHelper->expectsGetName_multiple_Success([$this->firstKeynameName, $this->secondKeynameName]);
        $this->keynameHelper->expectsGetValue_multiple_Success([$this->firstKeynameValue, $this->secondKeynameValue]);

        $httpRequest = $this->adapterWithPortHeaders->fromEntityRetrieverCriteriaToHttpRequestData($this->entityRetrieverCriteriaMock);

        $this->assertEquals($this->httpRequestDataWithKeynamesWithPortHeaders, $httpRequest);

    }

    public function testFromEntityRetrieverCriteriaToHttpRequestData_withKeyname_Success() {
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeynames_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeyname_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetKeyname_Success($this->keynameMock);
        $this->keynameHelper->expectsGetName_Success($this->firstKeynameName);
        $this->keynameHelper->expectsGetValue_Success($this->firstKeynameValue);

        $httpRequest = $this->adapter->fromEntityRetrieverCriteriaToHttpRequestData($this->entityRetrieverCriteriaMock);

        $this->assertEquals($this->httpRequestDataWithKeyname, $httpRequest);

    }

    public function testFromEntityRetrieverCriteriaToHttpRequestData_withKeyname_withPortHeaders_Success() {
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeynames_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeyname_Success(true);
        $this->entityRetrieverCriteriaHelper->expectsGetKeyname_Success($this->keynameMock);
        $this->keynameHelper->expectsGetName_Success($this->firstKeynameName);
        $this->keynameHelper->expectsGetValue_Success($this->firstKeynameValue);

        $httpRequest = $this->adapterWithPortHeaders->fromEntityRetrieverCriteriaToHttpRequestData($this->entityRetrieverCriteriaMock);

        $this->assertEquals($this->httpRequestDataWithKeynameWithPortHeaders, $httpRequest);

    }

    public function testFromEntityRetrieverCriteriaToHttpRequestData_withoutCritria_throwsRequestException() {
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRetrieverCriteriaHelper->expectsHasUuid_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeynames_Success(false);
        $this->entityRetrieverCriteriaHelper->expectsHasKeyname_Success(false);

        $asserted = false;
        try {

            $this->adapter->fromEntityRetrieverCriteriaToHttpRequestData($this->entityRetrieverCriteriaMock);

        } catch (RequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
