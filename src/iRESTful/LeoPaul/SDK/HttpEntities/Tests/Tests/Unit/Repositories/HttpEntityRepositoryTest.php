<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Applications\HttpApplicationHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters\RequestAdapterHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters\ResponseAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Repositories\HttpEntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class HttpEntityRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRepositoryMock;
    private $httpApplicationMock;
    private $httpResponseMock;
    private $requestAdapterMock;
    private $responseAdapterMock;
    private $entityAdapterAdapterMock;
    private $entityAdapterMock;
    private $entityMock;
    private $criteria;
    private $httpRequestData;
    private $entityData;
    private $outputEntityData;
    private $repository;
    private $httpApplicationHelper;
    private $requestAdapterHelper;
    private $responseAdapterHelper;
    private $entityAdapterAdapterHelper;
    private $entityAdapterHelper;
    public function setUp() {
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');
        $this->httpApplicationMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication');
        $this->httpResponseMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse');
        $this->requestAdapterMock = $this->createMock('iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Adapters\RequestAdapter');
        $this->responseAdapterMock = $this->createMock('iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters\ResponseAdapter');
        $this->entityAdapterAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->criteria = [
            'container' => 'my_container',
            'uuid' => '6681f4c9-560e-4598-9b38-e398b7557540'
        ];

        $this->httpRequestData = [
            'uri' => '/my_container/6681f4c9-560e-4598-9b38-e398b7557540',
            'method' => 'get',
            'port' => 80,
            'headers' => null
        ];

        $this->entityData = [
            'uuid' => '6681f4c9-560e-4598-9b38-e398b7557540',
            'title' => 'My Title',
            'description' => 'My Description',
            'created_on' => time()
        ];

        $this->outputEntityData = [
            'container' => 'my_container',
            'data' => [
                'uuid' => '6681f4c9-560e-4598-9b38-e398b7557540',
                'title' => 'My Title',
                'description' => 'My Description',
                'created_on' => time()
            ]
        ];

        $this->repository = new HttpEntityRepository($this->httpApplicationMock, $this->requestAdapterMock, $this->responseAdapterMock, $this->entityAdapterAdapterMock);

        $this->httpApplicationHelper = new HttpApplicationHelper($this, $this->httpApplicationMock);
        $this->requestAdapterHelper = new RequestAdapterHelper($this, $this->requestAdapterMock);
        $this->responseAdapterHelper = new ResponseAdapterHelper($this, $this->responseAdapterMock);
        $this->entityAdapterAdapterHelper = new EntityAdapterAdapterHelper($this, $this->entityAdapterAdapterMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);

    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->requestAdapterHelper->expectsFromDataToEntityHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_Success($this->entityData, $this->httpResponseMock);
        $this->entityAdapterAdapterHelper->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->repository, $this->entityRelationRepositoryMock);
        $this->entityAdapterHelper->expectsFromDataToEntity_Success($this->entityMock, $this->outputEntityData);

        $this->repository->addEntityRelationRepository($this->entityRelationRepositoryMock);
        $entity = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entityMock, $entity);

    }

    public function testRetrieve_withoutContainerInCriteria_throwsEntityException() {

        unset($this->criteria['container']);

        $asserted = false;
        try {

            $this->repository->addEntityRelationRepository($this->entityRelationRepositoryMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withoutAddingEntityAdapterFactory_throwsEntityException() {
        
        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsEntityException() {

        $this->requestAdapterHelper->expectsFromDataToEntityHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_Success($this->entityData, $this->httpResponseMock);
        $this->entityAdapterAdapterHelper->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->repository, $this->entityRelationRepositoryMock);
        $this->entityAdapterHelper->expectsFromDataToEntity_throwsEntityException($this->outputEntityData);

        $asserted = false;
        try {

            $this->repository->addEntityRelationRepository($this->entityRelationRepositoryMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsResponseException_throwsEntityException() {

        $this->requestAdapterHelper->expectsFromDataToEntityHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_throwsResponseException($this->httpResponseMock);

        $asserted = false;
        try {

            $this->repository->addEntityRelationRepository($this->entityRelationRepositoryMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsHttpException_throwsEntityException() {

        $this->requestAdapterHelper->expectsFromDataToEntityHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_throwsHttpException($this->httpRequestData);

        $asserted = false;
        try {

            $this->repository->addEntityRelationRepository($this->entityRelationRepositoryMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsRequestException_throwsEntityException() {

        $this->requestAdapterHelper->expectsFromDataToEntityHttpRequestData_throwsRequestException($this->criteria);

        $asserted = false;
        try {

            $this->repository->addEntityRelationRepository($this->entityRelationRepositoryMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExists_returnsTrue_Success() {

        $this->requestAdapterHelper->expectsFromDataToEntityHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_Success($this->entityData, $this->httpResponseMock);
        $this->entityAdapterAdapterHelper->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->repository, $this->entityRelationRepositoryMock);
        $this->entityAdapterHelper->expectsFromDataToEntity_Success($this->entityMock, $this->outputEntityData);

        $this->repository->addEntityRelationRepository($this->entityRelationRepositoryMock);
        $exists = $this->repository->exists($this->criteria);

        $this->assertTrue($exists);

    }

    public function testExists_returnsFalse_Success() {

        $this->requestAdapterHelper->expectsFromDataToEntityHttpRequestData_Success($this->httpRequestData, $this->criteria);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->httpRequestData);
        $this->responseAdapterHelper->expectsFromHttpResponseToData_returnsNull_Success($this->httpResponseMock);

        $this->repository->addEntityRelationRepository($this->entityRelationRepositoryMock);
        $exists = $this->repository->exists($this->criteria);

        $this->assertFalse($exists);

    }

}
