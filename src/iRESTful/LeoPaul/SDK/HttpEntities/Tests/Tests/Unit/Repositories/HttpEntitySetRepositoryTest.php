<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories\HttpEntitySetRepository;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Applications\HttpApplicationHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters\RequestSetAdapterHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters\ResponseAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityAdapterFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class HttpEntitySetRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $httpApplicationMock;
    private $httpResponseMock;
    private $requestSetAdapterMock;
    private $responseAdapterMock;
    private $entityAdapterFactoryMock;
    private $entityAdapterMock;
    private $entityMock;
    private $containerName;
    private $criteria;
    private $httpRequestData;
    private $data;
    private $entitiesData;
    private $entities;
    private $repository;
    private $httpApplicationHelper;
    private $requestSetAdapterHelper;
    private $responseAdapterHelper;
    private $entityAdapterFactoryHelper;
    private $entityAdapterHelper;
    public function setUp() {
        $this->httpApplicationMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication');
        $this->httpResponseMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse');
        $this->requestSetAdapterMock = $this->createMock('iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Adapters\RequestSetAdapter');
        $this->responseAdapterMock = $this->createMock('iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters\ResponseAdapter');
        $this->entityAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->containerName = 'my_container';

        $this->criteria = [
            'container' => $this->containerName,
            'uuids' => [
                '495929ec-eae2-4ad5-ab4f-b1b57ce7abd5',
                'f536c839-f44b-42a5-b8a3-9cf39220d31f'
            ]
        ];

        $this->httpRequestData = [
            'uri' => '/'.$this->containerName,
            'query_parameters' => [
                'uuids' => [
                    '495929ec-eae2-4ad5-ab4f-b1b57ce7abd5',
                    'f536c839-f44b-42a5-b8a3-9cf39220d31f'
                ]
            ],
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->data = [
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
        ];

        $this->entitiesData = [
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
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->repository = new HttpEntitySetRepository($this->httpApplicationMock , $this->requestSetAdapterMock, $this->responseAdapterMock, $this->entityAdapterFactoryMock);

        $this->httpApplicationHelper = new HttpApplicationHelper($this, $this->httpApplicationMock);
        $this->requestSetAdapterHelper = new RequestSetAdapterHelper($this, $this->requestSetAdapterMock);
        $this->responseAdapterHelper = new ResponseAdapterHelper($this, $this->responseAdapterMock);
        $this->entityAdapterFactoryHelper = new EntityAdapterFactoryHelper($this, $this->entityAdapterFactoryMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {
        $this->requestSetAdapterHelper->expectsFromDataToEntitySetHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_Success($this->data, $this->httpResponseMock);
        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromDataToEntities_Success($this->entities, $this->entitiesData);

        $entities = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entities, $entities);

    }

    public function testRetrieve_withoutResults_Success() {
        $this->requestSetAdapterHelper->expectsFromDataToEntitySetHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_returnsNull_Success($this->httpResponseMock);

        $entities = $this->repository->retrieve($this->criteria);

        $this->assertEquals([], $entities);

    }

    public function testRetrieve_withoutContainerInCriteria_throwsEntitySetException() {

        unset($this->criteria['container']);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsEntityException_throwsEntitySetException() {
        $this->requestSetAdapterHelper->expectsFromDataToEntitySetHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_Success($this->data, $this->httpResponseMock);
        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromDataToEntities_throwsEntityException($this->entitiesData);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsResponseException_throwsEntitySetException() {
        $this->requestSetAdapterHelper->expectsFromDataToEntitySetHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_throwsResponseException($this->httpResponseMock);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsHttpException_throwsEntitySetException() {
        $this->requestSetAdapterHelper->expectsFromDataToEntitySetHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_throwsHttpException($this->httpRequestData);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsRequestSetException_throwsEntitySetException() {
        $this->requestSetAdapterHelper->expectsFromDataToEntitySetHttpRequestData_throwsRequestSetException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
