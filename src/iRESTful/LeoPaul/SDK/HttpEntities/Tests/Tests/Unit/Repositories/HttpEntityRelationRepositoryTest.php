<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories\HttpEntityRelationRepository;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Applications\HttpApplicationHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters\RequestRelationAdapterHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters\ResponseAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityAdapterFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class HttpEntityRelationRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $httpApplicationMock;
    private $requestRelationAdapterMock;
    private $responseAdapterMock;
    private $httpResponseMock;
    private $entityAdapterFactoryMock;
    private $entityAdapterMock;
    private $entityMock;
    private $criteria;
    private $httpRequestData;
    private $data;
    private $outputData;
    private $entities;
    private $repository;
    private $httpApplicationHelper;
    private $requestRelationAdapterHelper;
    private $responseAdapterHelper;
    private $entityAdapterFactoryHelper;
    public function setUp() {
        $this->httpApplicationMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication');
        $this->httpResponseMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse');
        $this->requestRelationAdapterMock = $this->createMock('iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Relations\Adapters\RequestRelationAdapter');
        $this->responseAdapterMock = $this->createMock('iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters\ResponseAdapter');
        $this->entityAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->criteria = [
            'master_container' => 'roles',
            'slave_container' => 'permissions',
            'slave_property' => 'one_permission',
            'master_uuid' => 'feda327a-3b3a-4283-a4b2-3b4b733142e1'
        ];


        $this->httpRequestData = [
            'uri' => '/roles/feda327a-3b3a-4283-a4b2-3b4b733142e1/one_permission/permissions',
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

        $this->outputData = [
            [
                'container' => 'permissions',
                'data' => [
                    'uuid' => '495929ec-eae2-4ad5-ab4f-b1b57ce7abd5',
                    'title' => 'Some Title',
                    'description' => 'Some Description',
                    'created_on' => time()
                ]
            ],
            [
                'container' => 'permissions',
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

        $this->repository = new HttpEntityRelationRepository($this->httpApplicationMock , $this->requestRelationAdapterMock, $this->responseAdapterMock);

        $this->httpApplicationHelper = new HttpApplicationHelper($this, $this->httpApplicationMock);
        $this->requestRelationAdapterHelper = new RequestRelationAdapterHelper($this, $this->requestRelationAdapterMock);
        $this->responseAdapterHelper = new ResponseAdapterHelper($this, $this->responseAdapterMock);
        $this->entityAdapterFactoryHelper = new EntityAdapterFactoryHelper($this, $this->entityAdapterFactoryMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_Success($this->data, $this->httpResponseMock);
        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromDataToEntities_Success($this->entities, $this->outputData);

        $this->repository->addEntityAdapterFactory($this->entityAdapterFactoryMock);
        $entities = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entities, $entities);

    }

    public function testRetrieve_withoutAddingEntityAdapterFactory_Success() {

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withEmptyResults_Success() {

        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_returnsNull_Success($this->httpResponseMock);

        $this->repository->addEntityAdapterFactory($this->entityAdapterFactoryMock);
        $entities = $this->repository->retrieve($this->criteria);

        $this->assertEquals([], $entities);

    }

    public function testRetrieve_throwsEntityException_throwsEntityRelationException() {

        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_Success($this->data, $this->httpResponseMock);
        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromDataToEntities_throwsEntityException($this->outputData);

        $asserted = false;
        try {

            $this->repository->addEntityAdapterFactory($this->entityAdapterFactoryMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsResponseException_throwsEntityRelationException() {

        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_throwsResponseException($this->httpResponseMock);

        $asserted = false;
        try {

            $this->repository->addEntityAdapterFactory($this->entityAdapterFactoryMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsHttpException_throwsEntityRelationException() {

        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_throwsHttpException($this->httpRequestData);

        $asserted = false;
        try {

            $this->repository->addEntityAdapterFactory($this->entityAdapterFactoryMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsRequestRelationException_throwsEntityRelationException() {

        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationHttpRequestData_throwsRequestRelationException($this->criteria);

        $asserted = false;
        try {

            $this->repository->addEntityAdapterFactory($this->entityAdapterFactoryMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withoutSlaveContainerInCriteria_throwsEntityRelationException() {

        unset($this->criteria['slave_container']);

        $asserted = false;
        try {

            $this->repository->addEntityAdapterFactory($this->entityAdapterFactoryMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
