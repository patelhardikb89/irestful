<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteRequestSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntitySetRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntitySetRetrieverCriteriaHelper;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Adapters\UuidAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\OrderingAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\KeynameHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Exceptions\RequestSetException;

final class ConcreteRequestSetAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entitySetRetrieverCriteriaAdapterMock;
    private $entitySetRetrieverCriteriaMock;
    private $uuidAdapterMock;
    private $uuidMock;
    private $orderingAdapterMock;
    private $orderingMock;
    private $keynameMock;
    private $criteria;
    private $containerName;
    private $uuids;
    private $uuidsData;
    private $keynameName;
    private $keynameValue;
    private $orderingData;
    private $port;
    private $headers;
    private $requestDataWithUuids;
    private $requestDataWithUuidsOrdering;
    private $requestDataWithKeyname;
    private $requestDataWithKeynameOrdering;
    private $requestDataWithUuidsWithPortHeaders;
    private $requestDataWithKeynameWithPortHeaders;
    private $adapter;
    private $adapterWithPortHeaders;
    private $entitySetRetrieverCriteriaAdapterHelper;
    private $entitySetRetrieverCriteriaHelper;
    private $uuidAdapterHelper;
    private $orderingAdapterHelper;
    private $keynameHelper;
    public function setUp() {
        $this->entitySetRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\EntitySetRetrieverCriteriaAdapter');
        $this->entitySetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria');
        $this->uuidAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->orderingAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');
        $this->keynameMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname');

        $this->containerName = 'my_container';
        $this->uuids = [
            $this->uuidMock,
            $this->uuidMock
        ];

        $this->uuidsData = [
            'e8748119-cf5d-4fae-978f-ea15ef816ce5',
            '495929ec-eae2-4ad5-ab4f-b1b57ce7abd5'
        ];
        $this->keynameName = 'slug';
        $this->keynameValue = 'my-slug';

        $this->criteria = [
            'container' => $this->containerName,
            'uuid' => $this->uuidsData
        ];

        $this->port = rand(1, 500);
        $this->headers = [
            'some' => 'headers'
        ];

        $this->orderingData = [
            'names' => ['slug', 'created_on'],
            'is_ascending' => false
        ];

        $this->requestDataWithUuids = [
            'uri' => '/'.$this->containerName,
            'query_parameters' => [
                'uuids' => $this->uuidsData
            ],
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->requestDataWithUuidsOrdering = [
            'uri' => '/'.$this->containerName,
            'query_parameters' => [
                'uuids' => $this->uuidsData,
                'ordering' => $this->orderingData
            ],
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->requestDataWithKeyname = [
            'uri' => '/'.$this->containerName.'/'.$this->keynameName.'/'.$this->keynameValue,
            'query_parameters' => [],
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->requestDataWithKeynameOrdering = [
            'uri' => '/'.$this->containerName.'/'.$this->keynameName.'/'.$this->keynameValue,
            'query_parameters' => [
                'ordering' => $this->orderingData
            ],
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->requestDataWithUuidsWithPortHeaders = [
            'uri' => '/'.$this->containerName,
            'query_parameters' => [
                'uuids' => $this->uuidsData
            ],
            'method' => 'get',
            'port' => $this->port,
            'headers' => $this->headers
        ];

        $this->requestDataWithKeynameWithPortHeaders = [
            'uri' => '/'.$this->containerName.'/'.$this->keynameName.'/'.$this->keynameValue,
            'query_parameters' => [],
            'method' => 'get',
            'port' => $this->port,
            'headers' => $this->headers
        ];

        $this->adapter = new ConcreteRequestSetAdapter($this->entitySetRetrieverCriteriaAdapterMock, $this->uuidAdapterMock, $this->orderingAdapterMock);
        $this->adapterWithPortHeaders = new ConcreteRequestSetAdapter($this->entitySetRetrieverCriteriaAdapterMock, $this->uuidAdapterMock, $this->orderingAdapterMock, $this->port, $this->headers);

        $this->entitySetRetrieverCriteriaAdapterHelper = new EntitySetRetrieverCriteriaAdapterHelper($this, $this->entitySetRetrieverCriteriaAdapterMock);
        $this->entitySetRetrieverCriteriaHelper = new EntitySetRetrieverCriteriaHelper($this, $this->entitySetRetrieverCriteriaMock);
        $this->uuidAdapterHelper = new UuidAdapterHelper($this, $this->uuidAdapterMock);
        $this->orderingAdapterHelper = new OrderingAdapterHelper($this, $this->orderingAdapterMock);
        $this->keynameHelper = new KeynameHelper($this, $this->keynameMock);
    }

    public function tearDown() {

    }

    public function testFromEntitySetRetrieverCriteriaToHttpRequestData_withUuids_Success() {
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetUuids_Success($this->uuids);
        $this->uuidAdapterHelper->expectsFromUuidsToHumanReadableStrings_Success($this->uuidsData, $this->uuids);

        $httpRequest = $this->adapter->fromEntitySetRetrieverCriteriaToHttpRequestData($this->entitySetRetrieverCriteriaMock);

        $this->assertEquals($this->requestDataWithUuids, $httpRequest);
    }

    public function testFromEntitySetRetrieverCriteriaToHttpRequestData_withUuids_throwsUuidException_throwsRequestSetException() {
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetUuids_Success($this->uuids);
        $this->uuidAdapterHelper->expectsFromUuidsToHumanReadableStrings_throwsUuidException($this->uuids);

        $asserted = false;
        try {

            $this->adapter->fromEntitySetRetrieverCriteriaToHttpRequestData($this->entitySetRetrieverCriteriaMock);

        } catch (RequestSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromEntitySetRetrieverCriteriaToHttpRequestData_withUuids_throwsOrderingException_throwsRequestSetException() {
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetOrdering_Success($this->orderingMock);
        $this->orderingAdapterHelper->expectsFromOrderingToData_throwsOrderingException($this->orderingMock);

        $asserted = false;
        try {

            $this->adapter->fromEntitySetRetrieverCriteriaToHttpRequestData($this->entitySetRetrieverCriteriaMock);

        } catch (RequestSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromEntitySetRetrieverCriteriaToHttpRequestData_withUuids_withOrdering_Success() {
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetOrdering_Success($this->orderingMock);
        $this->orderingAdapterHelper->expectsFromOrderingToData_Success($this->orderingData, $this->orderingMock);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetUuids_Success($this->uuids);
        $this->uuidAdapterHelper->expectsFromUuidsToHumanReadableStrings_Success($this->uuidsData, $this->uuids);

        $httpRequest = $this->adapter->fromEntitySetRetrieverCriteriaToHttpRequestData($this->entitySetRetrieverCriteriaMock);

        $this->assertEquals($this->requestDataWithUuidsOrdering, $httpRequest);
    }

    public function testFromEntitySetRetrieverCriteriaToHttpRequestData_withKeyname_Success() {
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetKeyname_Success($this->keynameMock);
        $this->keynameHelper->expectsGetName_Success($this->keynameName);
        $this->keynameHelper->expectsGetValue_Success($this->keynameValue);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(false);

        $httpRequest = $this->adapter->fromEntitySetRetrieverCriteriaToHttpRequestData($this->entitySetRetrieverCriteriaMock);

        $this->assertEquals($this->requestDataWithKeyname, $httpRequest);
    }

    public function testFromEntitySetRetrieverCriteriaToHttpRequestData_withKeyname_withOrdering_Success() {
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetKeyname_Success($this->keynameMock);
        $this->keynameHelper->expectsGetName_Success($this->keynameName);
        $this->keynameHelper->expectsGetValue_Success($this->keynameValue);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetOrdering_Success($this->orderingMock);
        $this->orderingAdapterHelper->expectsFromOrderingToData_Success($this->orderingData, $this->orderingMock);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(false);

        $httpRequest = $this->adapter->fromEntitySetRetrieverCriteriaToHttpRequestData($this->entitySetRetrieverCriteriaMock);

        $this->assertEquals($this->requestDataWithKeynameOrdering, $httpRequest);
    }

    public function testFromEntitySetRetrieverCriteriaToHttpRequestData_withUuids_withPort_withHeaders_Success() {
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetUuids_Success($this->uuids);
        $this->uuidAdapterHelper->expectsFromUuidsToHumanReadableStrings_Success($this->uuidsData, $this->uuids);

        $httpRequest = $this->adapterWithPortHeaders->fromEntitySetRetrieverCriteriaToHttpRequestData($this->entitySetRetrieverCriteriaMock);

        $this->assertEquals($this->requestDataWithUuidsWithPortHeaders, $httpRequest);
    }

    public function testFromEntitySetRetrieverCriteriaToHttpRequestData_withKeyname_withPort_withHeaders_Success() {
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetKeyname_Success($this->keynameMock);
        $this->keynameHelper->expectsGetName_Success($this->keynameName);
        $this->keynameHelper->expectsGetValue_Success($this->keynameValue);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(false);

        $httpRequest = $this->adapterWithPortHeaders->fromEntitySetRetrieverCriteriaToHttpRequestData($this->entitySetRetrieverCriteriaMock);

        $this->assertEquals($this->requestDataWithKeynameWithPortHeaders, $httpRequest);
    }

    public function testFromDataToEntitySetHttpRequestData_Success() {
        $this->entitySetRetrieverCriteriaAdapterHelper->expectsFromDataToEntitySetRetrieverCriteria_Success($this->entitySetRetrieverCriteriaMock, $this->criteria);
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRetrieverCriteriaHelper->expectsHasKeyname_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);
        $this->entitySetRetrieverCriteriaHelper->expectsHasUuids_Success(true);
        $this->entitySetRetrieverCriteriaHelper->expectsGetUuids_Success($this->uuids);
        $this->uuidAdapterHelper->expectsFromUuidsToHumanReadableStrings_Success($this->uuidsData, $this->uuids);

        $httpRequest = $this->adapter->fromDataToEntitySetHttpRequestData($this->criteria);

        $this->assertEquals($this->requestDataWithUuids, $httpRequest);
    }

    public function testFromDataToEntitySetHttpRequestData_throwsEntitySetException_throwsRequestSetException() {
        $this->entitySetRetrieverCriteriaAdapterHelper->expectsFromDataToEntitySetRetrieverCriteria_throwsEntitySetException($this->criteria);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntitySetHttpRequestData($this->criteria);

        } catch (RequestSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
