<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteRequestPartialSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\OrderingAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityPartialSetRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityPartialSetRetrieverCriteriaHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Partials\Exceptions\RequestPartialSetException;

final class ConcreteRequestPartialSetAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetRetrieverCriteriaAdapterMock;
    private $entityPartialSetRetrieverCriteriaMock;
    private $orderingAdapterMock;
    private $orderingMock;
    private $containerName;
    private $criteria;
    private $index;
    private $amount;
    private $port;
    private $headers;
    private $orderingData;
    private $requestData;
    private $requestDataWithOrdering;
    private $requestDataWithPortHeaders;
    private $adapter;
    private $adapterWithPortHeaders;
    private $entityPartialSetRetrieverCriteriaAdapterHelper;
    private $entityPartialSetRetrieverCriteriaHelper;
    private $orderingAdapterHelper;
    public function setUp() {
        $this->entityPartialSetRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\EntityPartialSetRetrieverCriteriaAdapter');
        $this->entityPartialSetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria');
        $this->orderingAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');

        $this->containerName = 'my_container';
        $this->index = rand(0, 100);
        $this->amount = rand(1, 100);

        $this->orderingData = [
            'names' => ['slug', 'created_on'],
            'is_ascending' => false
        ];

        $this->criteria = [
            'container' => $this->containerName,
            'index' => $this->index,
            'amount' => $this->amount
        ];

        $this->port = rand(1, 1000);
        $this->headers = [
            'some' => 'headers'
        ];

        $this->requestData = [
            'uri' => '/'.$this->containerName.'/partials',
            'query_parameters' => [
                'index' => $this->index,
                'amount' => $this->amount
            ],
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->requestDataWithOrdering = [
            'uri' => '/'.$this->containerName.'/partials',
            'query_parameters' => [
                'index' => $this->index,
                'amount' => $this->amount,
                'ordering' => $this->orderingData
            ],
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->requestDataWithPortHeaders = [
            'uri' => '/'.$this->containerName.'/partials',
            'query_parameters' => [
                'index' => $this->index,
                'amount' => $this->amount
            ],
            'method' => 'get',
            'port' => $this->port,
            'headers' => $this->headers
        ];

        $this->adapter = new ConcreteRequestPartialSetAdapter($this->entityPartialSetRetrieverCriteriaAdapterMock, $this->orderingAdapterMock);
        $this->adapterWithPortHeaders = new ConcreteRequestPartialSetAdapter($this->entityPartialSetRetrieverCriteriaAdapterMock, $this->orderingAdapterMock, $this->port, $this->headers);

        $this->entityPartialSetRetrieverCriteriaAdapterHelper = new EntityPartialSetRetrieverCriteriaAdapterHelper($this, $this->entityPartialSetRetrieverCriteriaAdapterMock);
        $this->entityPartialSetRetrieverCriteriaHelper = new EntityPartialSetRetrieverCriteriaHelper($this, $this->entityPartialSetRetrieverCriteriaMock);
        $this->orderingAdapterHelper = new OrderingAdapterHelper($this, $this->orderingAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromEntityPartialSetRetrieverCriteriaToHttpRequestData_Success() {

        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetAmount_Success($this->amount);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);

        $httpRequest = $this->adapter->fromEntityPartialSetRetrieverCriteriaToHttpRequestData($this->entityPartialSetRetrieverCriteriaMock);

        $this->assertEquals($this->requestData, $httpRequest);
    }

    public function testFromEntityPartialSetRetrieverCriteriaToHttpRequestData_withOrdering_Success() {

        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetAmount_Success($this->amount);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsHasOrdering_Success(true);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetOrdering_Success($this->orderingMock);
        $this->orderingAdapterHelper->expectsFromOrderingToData_Success($this->orderingData, $this->orderingMock);

        $httpRequest = $this->adapter->fromEntityPartialSetRetrieverCriteriaToHttpRequestData($this->entityPartialSetRetrieverCriteriaMock);

        $this->assertEquals($this->requestDataWithOrdering, $httpRequest);
    }

    public function testFromEntityPartialSetRetrieverCriteriaToHttpRequestData_withPort_withHeaders_Success() {

        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetAmount_Success($this->amount);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);

        $httpRequest = $this->adapterWithPortHeaders->fromEntityPartialSetRetrieverCriteriaToHttpRequestData($this->entityPartialSetRetrieverCriteriaMock);

        $this->assertEquals($this->requestDataWithPortHeaders, $httpRequest);
    }

    public function testFromEntityPartialSetRetrieverCriteriaToHttpRequestData_withOrdering_throwsOrderingException_throwsRequestPartialSetException() {

        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetAmount_Success($this->amount);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsHasOrdering_Success(true);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetOrdering_Success($this->orderingMock);
        $this->orderingAdapterHelper->expectsFromOrderingToData_throwsOrderingException($this->orderingMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityPartialSetRetrieverCriteriaToHttpRequestData($this->entityPartialSetRetrieverCriteriaMock);

        } catch (RequestPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToEntityPartialSetHttpRequestData_Success() {

        $this->entityPartialSetRetrieverCriteriaAdapterHelper->expectsFromDataToEntityPartialSetRetrieverCriteria_Success($this->entityPartialSetRetrieverCriteriaMock, $this->criteria);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetAmount_Success($this->amount);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);

        $httpRequest = $this->adapter->fromDataToEntityPartialSetHttpRequestData($this->criteria);

        $this->assertEquals($this->requestData, $httpRequest);
    }

    public function testFromDataToEntityPartialSetHttpRequestData_throwsEntityPartialSetException_throwsRequestPartialSetException() {

        $this->entityPartialSetRetrieverCriteriaAdapterHelper->expectsFromDataToEntityPartialSetRetrieverCriteria_throwsEntityPartialSetException($this->criteria);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetHttpRequestData($this->criteria);

        } catch (RequestPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
