<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories\HttpEntityPartialSetRepository;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Applications\HttpApplicationHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters\RequestPartialSetAdapterHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters\ResponseAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityPartialSetAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class HttpEntityPartialSetRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $httpApplicationMock;
    private $httpResponseMock;
    private $requestPartialSetAdapterMock;
    private $responseAdapterMock;
    private $entityPartialSetAdapterMock;
    private $entityPartialSetMock;
    private $containerName;
    private $index;
    private $amount;
    private $totalAmount;
    private $criteria;
    private $httpRequestData;
    private $data;
    private $entitiesData;
    private $repository;
    private $httpApplicationHelper;
    private $requestPartialSetAdapterHelper;
    private $responseAdapterHelper;
    private $entityPartialSetAdapterHelper;
    public function setUp() {
        $this->httpApplicationMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication');
        $this->httpResponseMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse');
        $this->requestPartialSetAdapterMock = $this->createMock('iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Partials\Adapters\RequestPartialSetAdapter');
        $this->responseAdapterMock = $this->createMock('iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters\ResponseAdapter');
        $this->entityPartialSetAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter');
        $this->entityPartialSetMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet');

        $this->containerName = 'my_container';
        $this->index = rand(0, 100);
        $this->amount = rand(1, 100);
        $this->totalAmount = rand(1000, 10000);

        $this->criteria = [
            'container' => $this->containerName,
            'index' => $this->index,
            'amount' => $this->amount
        ];

        $this->httpRequestData =  [
            'uri' => '/'.$this->containerName,
            'query_parameters' => [
                'index' => $this->index,
                'amount' => $this->amount
            ],
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->data = [
            'index' => $this->index,
            'amount' => $this->amount,
            'total_amount' => $this->totalAmount,
            'entities' => [
                [
                    'uuid' => '495929ec-eae2-4ad5-ab4f-b1b57ce7abd5',
                    'title' => 'Some Title',
                    'description' => 'Some Description',
                    'created_on' => time()
                ],
                [
                    'uuid' => 'f536c839-f44b-42a5-b8a3-9cf39220d31f',
                    'title' => 'Some Other Title',
                    'description' => 'Some Other Description',
                    'created_on' => time()
                ]
            ]
        ];

        $this->entitiesData = [
            'index' => $this->index,
            'amount' => $this->amount,
            'total_amount' => $this->totalAmount,
            'entities' => [
                [
                    'container' => $this->containerName,
                    'data' => [
                        'uuid' => '495929ec-eae2-4ad5-ab4f-b1b57ce7abd5',
                        'title' => 'Some Title',
                        'description' => 'Some Description',
                        'created_on' => time()
                    ]
                ],
                [
                    'container' => $this->containerName,
                    'data' => [
                        'uuid' => 'f536c839-f44b-42a5-b8a3-9cf39220d31f',
                        'title' => 'Some Other Title',
                        'description' => 'Some Other Description',
                        'created_on' => time()
                    ]
                ]
            ]
        ];

        $this->repository = new HttpEntityPartialSetRepository($this->httpApplicationMock, $this->requestPartialSetAdapterMock, $this->responseAdapterMock, $this->entityPartialSetAdapterMock);


        $this->httpApplicationHelper = new HttpApplicationHelper($this, $this->httpApplicationMock);
        $this->requestPartialSetAdapterHelper = new RequestPartialSetAdapterHelper($this, $this->requestPartialSetAdapterMock);
        $this->responseAdapterHelper = new ResponseAdapterHelper($this, $this->responseAdapterMock);
        $this->entityPartialSetAdapterHelper = new EntityPartialSetAdapterHelper($this, $this->entityPartialSetAdapterMock);

    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_Success($this->data, $this->httpResponseMock);
        $this->entityPartialSetAdapterHelper->expectsFromDataToEntityPartialSet_Success($this->entityPartialSetMock, $this->entitiesData);

        $entityPartialSet = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entityPartialSetMock, $entityPartialSet);
    }

    public function testRetrieve_throwsEntityPartialSetException() {
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_Success($this->data, $this->httpResponseMock);
        $this->entityPartialSetAdapterHelper->expectsFromDataToEntityPartialSet_throwsEntityPartialSetException($this->entitiesData);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testRetrieve_dataIsNull_throwsEntityPartialSetException() {
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_returnsNull_Success($this->httpResponseMock);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testRetrieve_throwsResponseException_throwsEntityPartialSetException() {
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_throwsResponseException($this->httpResponseMock);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testRetrieve_throwsHttpException_throwsEntityPartialSetException() {
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_throwsHttpException($this->httpRequestData);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testRetrieve_throwsRequestPartialSetException_throwsEntityPartialSetException() {
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetHttpRequestData_throwsRequestPartialSetException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testRetrieve_withoutContainerInCriteria_throwsEntityPartialSetException() {

        unset($this->criteria['container']);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
