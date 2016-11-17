<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestEntityWithSubEntitiesAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\SubEntityRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\SubEntitySetRepositoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\SubEntitiesAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\RequestEntityAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions\RequestEntityException;

final class ConcreteRequestsEntityWithSubEntitiesAdapterTest extends \PHPUnit_Framework_TestCase {
    private $subEntitySetRepositoryMock;
    private $subEntityRepositoryMock;
    private $subEntitiesMock;
    private $subEntitiesAdapterMock;
    private $requestEntityAdapterMock;
    private $entityMock;
    private $entities;
    private $deleteRequests;
    private $subRequests;
    private $requests;
    private $allRequests;
    private $requestsWithDelete;
    private $allRequestsWithDelete;
    private $request;
    private $adapter;
    private $subEntitySetRepositoryHelper;
    private $subEntityRepositoryHelper;
    private $subEntitiesAdapterHelper;
    private $requestEntityAdapterHelper;
    public function setUp() {
        $this->subEntitySetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\SubEntitySetRepository');
        $this->subEntityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories\SubEntityRepository');
        $this->subEntitiesMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities');
        $this->subEntitiesAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Subs\Adapters\SubEntitiesAdapter');
        $this->requestEntityAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->subRequests = [
            'update' => [
                ['first' => 'sub request'],
                ['second' => 'sub request']
            ],
            'insert' => []
        ];

        $this->deleteRequests = [
            ['first delete' => 'delete requests'],
            ['second delete' => 'delete requests']
        ];

        $this->requests = [
            ['new' => 'request']
        ];

        $this->allRequests = [
            ['first' => 'sub request'],
            ['second' => 'sub request'],
            ['new' => 'request']
        ];

        $this->allRequestsWithDelete = [
            ['first delete' => 'delete requests'],
            ['second delete' => 'delete requests'],
            ['first' => 'sub request'],
            ['second' => 'sub request'],
            ['new' => 'request']
        ];

        $this->requestsWithDelete = [
            ['first delete' => 'delete requests'],
            ['second delete' => 'delete requests'],
            ['new' => 'request']
        ];

        $this->request = [
            'one' => 'request'
        ];

        $this->adapter = new ConcreteRequestEntityWithSubEntitiesAdapter($this->subEntitySetRepositoryMock, $this->subEntityRepositoryMock, $this->subEntitiesAdapterMock, $this->requestEntityAdapterMock);

        $this->subEntitySetRepositoryHelper = new SubEntitySetRepositoryHelper($this, $this->subEntitySetRepositoryMock);
        $this->subEntityRepositoryHelper = new SubEntityRepositoryHelper($this, $this->subEntityRepositoryMock);
        $this->subEntitiesAdapterHelper = new SubEntitiesAdapterHelper($this, $this->subEntitiesAdapterMock);
        $this->requestEntityAdapterHelper = new RequestEntityAdapterHelper($this, $this->requestEntityAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromEntityToInsertRequests_Success() {

        $this->subEntityRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entityMock);
        $this->subEntitiesAdapterHelper->expectsFromSubEntitiesToRequests_Success($this->subRequests, $this->subEntitiesMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToInsertRequests_Success($this->requests, $this->entityMock);

        $requests = $this->adapter->fromEntityToInsertRequests($this->entityMock);

        $this->assertEquals($this->allRequests, $requests);

    }

    public function testFromEntityToInsertRequests_hasNoSubEntities_throwsRequestEntityException() {

        $this->subEntityRepositoryHelper->expectsRetrieve_returnsNull_Success($this->entityMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToInsertRequests_Success($this->requests, $this->entityMock);

        $requests = $this->adapter->fromEntityToInsertRequests($this->entityMock);

        $this->assertEquals($this->requests, $requests);

    }

    public function testFromEntityToInsertRequests_throwsRequestEntityException() {

        $this->subEntityRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entityMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToInsertRequests_throwsRequestEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToInsertRequests($this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToInsertRequests_throwsRequestSubEntitiesException_throwsRequestEntityException() {

        $this->subEntityRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entityMock);
        $this->subEntitiesAdapterHelper->expectsFromSubEntitiesToRequests_throwsRequestSubEntitiesException($this->subEntitiesMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToInsertRequests($this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToInsertRequests_throwsSubEntityException_throwsRequestEntityException() {

        $this->subEntityRepositoryHelper->expectsRetrieve_throwsSubEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToInsertRequests($this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToInsertRequests_Success() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToInsertRequests_Success($this->requests, $this->entities);
        $this->subEntitiesAdapterHelper->expectsFromSubEntitiesToRequests_Success($this->subRequests, $this->subEntitiesMock);

        $requests = $this->adapter->fromEntitiesToInsertRequests($this->entities);

        $this->assertEquals($this->allRequests, $requests);

    }

    public function testFromEntitiesToInsertRequests_withoutSubEntities_Success() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_returnsNull_Success($this->entities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToInsertRequests_Success($this->requests, $this->entities);

        $requests = $this->adapter->fromEntitiesToInsertRequests($this->entities);

        $this->assertEquals($this->requests, $requests);

    }

    public function testFromEntitiesToInsertRequests_throwsRequestEntityException() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToInsertRequests_throwsRequestEntityException($this->entities);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToInsertRequests($this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToInsertRequests_throwsRequestSubEntitiesException_throwsRequestEntityException() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entities);
        $this->subEntitiesAdapterHelper->expectsFromSubEntitiesToRequests_throwsRequestSubEntitiesException($this->subEntitiesMock);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToInsertRequests($this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToInsertRequests_throwsSubEntityException_throwsRequestEntityException() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_throwsSubEntityException($this->entities);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToInsertRequests($this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToUpdateRequests_Success() {

        $this->subEntityRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entityMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToParentDeleteRequests_Success($this->deleteRequests, $this->entityMock);
        $this->subEntitiesAdapterHelper->expectsFromSubEntitiesToRequests_Success($this->subRequests, $this->subEntitiesMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_Success($this->requests, $this->entityMock, $this->entityMock);

        $requests = $this->adapter->fromEntityToUpdateRequests($this->entityMock, $this->entityMock);

        $this->assertEquals($this->allRequestsWithDelete, $requests);

    }

    public function testFromEntityToUpdateRequests_withEmptyDeleteRequests_Success() {

        $this->subEntityRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entityMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToParentDeleteRequests_Success([], $this->entityMock);
        $this->subEntitiesAdapterHelper->expectsFromSubEntitiesToRequests_Success($this->subRequests, $this->subEntitiesMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_Success($this->requests, $this->entityMock, $this->entityMock);

        $requests = $this->adapter->fromEntityToUpdateRequests($this->entityMock, $this->entityMock);

        $this->assertEquals($this->allRequests, $requests);

    }

    public function testFromEntityToUpdateRequests_withNoSubEntities_Success() {

        $this->subEntityRepositoryHelper->expectsRetrieve_returnsNull_Success($this->entityMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_Success($this->requests, $this->entityMock, $this->entityMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToParentDeleteRequests_Success($this->deleteRequests, $this->entityMock);

        $requests = $this->adapter->fromEntityToUpdateRequests($this->entityMock, $this->entityMock);

        $this->assertEquals($this->requestsWithDelete, $requests);

    }

    public function testFromEntityToUpdateRequests_throwsRequestEntityException() {

        $this->subEntityRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entityMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_throwsRequestEntityException($this->entityMock, $this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToUpdateRequests($this->entityMock, $this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToUpdateRequests_throwsRequestSubEntitiesException_throwsRequestEntityException() {

        $this->subEntityRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entityMock);
        $this->requestEntityAdapterHelper->expectsFromEntityToParentDeleteRequests_Success($this->deleteRequests, $this->entityMock);
        $this->subEntitiesAdapterHelper->expectsFromSubEntitiesToRequests_throwsRequestSubEntitiesException($this->subEntitiesMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToUpdateRequests($this->entityMock, $this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToUpdateRequests_throwsSubEntityException_throwsRequestEntityException() {

        $this->subEntityRepositoryHelper->expectsRetrieve_throwsSubEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToUpdateRequests($this->entityMock, $this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToUpdateRequests_Success() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToParentDeleteRequests_Success($this->deleteRequests, $this->entities);
        $this->subEntitiesAdapterHelper->expectsFromSubEntitiesToRequests_Success($this->subRequests, $this->subEntitiesMock);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToUpdateRequests_Success($this->requests, $this->entities, $this->entities);

        $requests = $this->adapter->fromEntitiesToUpdateRequests($this->entities, $this->entities);

        $this->assertEquals($this->allRequestsWithDelete, $requests);

    }

    public function testFromEntitiesToUpdateRequests_withoutParentDeleteRequests_Success() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToParentDeleteRequests_Success([], $this->entities);
        $this->subEntitiesAdapterHelper->expectsFromSubEntitiesToRequests_Success($this->subRequests, $this->subEntitiesMock);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToUpdateRequests_Success($this->requests, $this->entities, $this->entities);

        $requests = $this->adapter->fromEntitiesToUpdateRequests($this->entities, $this->entities);

        $this->assertEquals($this->allRequests, $requests);

    }

    public function testFromEntitiesToUpdateRequests_withoutSubEntities_Success() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_returnsNull_Success($this->entities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToParentDeleteRequests_Success($this->deleteRequests, $this->entities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToUpdateRequests_Success($this->requests, $this->entities, $this->entities);

        $requests = $this->adapter->fromEntitiesToUpdateRequests($this->entities, $this->entities);

        $this->assertEquals($this->requestsWithDelete, $requests);

    }

    public function testFromEntitiesToUpdateRequests_throwsRequestEntityException() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToUpdateRequests_throwsRequestEntityException($this->entities, $this->entities);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToUpdateRequests($this->entities, $this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToUpdateRequests_throwsRequestEntityException_throwsRequestEntityException() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToUpdateRequests_throwsRequestEntityException($this->entities, $this->entities);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToUpdateRequests($this->entities, $this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToUpdateRequests_throwsRequestSubEntitiesException_throwsRequestEntityException() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_Success($this->subEntitiesMock, $this->entities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToParentDeleteRequests_Success($this->deleteRequests, $this->entities);
        $this->subEntitiesAdapterHelper->expectsFromSubEntitiesToRequests_throwsRequestSubEntitiesException($this->subEntitiesMock);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToUpdateRequests($this->entities, $this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToUpdateRequests_throwsSubEntityException_throwsRequestEntityException() {

        $this->subEntitySetRepositoryHelper->expectsRetrieve_throwsSubEntityException($this->entities);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToUpdateRequests($this->entities, $this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToDeleteRequests_Success() {

        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_Success([$this->request], $this->entityMock);

        $requests = $this->adapter->fromEntityToDeleteRequests($this->entityMock);

        $this->assertEquals([$this->request], $requests);

    }

    public function testFromEntityToDeleteRequests_throwsRequestEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_throwsRequestEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToDeleteRequests($this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToDeleteRequests_Success() {

        $this->requestEntityAdapterHelper->expectsFromEntitiesToDeleteRequests_Success($this->requests, $this->entities);

        $requests = $this->adapter->fromEntitiesToDeleteRequests($this->entities);

        $this->assertEquals($this->requests, $requests);

    }

    public function testFromEntitiesToDeleteRequests_throwsRequestEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntitiesToDeleteRequests_throwsRequestEntityException($this->entities);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToDeleteRequests($this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToParentDeleteRequests_Success() {

        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_Success($this->deleteRequests, $this->entityMock);

        $parentDeleteRequests = $this->adapter->fromEntityToParentDeleteRequests($this->entityMock);

        $this->assertEquals($this->deleteRequests, $parentDeleteRequests);

    }

    public function testFromEntityToParentDeleteRequests_throwsRequestEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_throwsRequestEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToParentDeleteRequests($this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToParentDeleteRequests_Success() {

        $this->requestEntityAdapterHelper->expectsFromEntitiesToDeleteRequests_Success($this->deleteRequests, $this->entities);

        $parentDeleteRequests = $this->adapter->fromEntitiesToParentDeleteRequests($this->entities);

        $this->assertEquals($this->deleteRequests, $parentDeleteRequests);

    }

    public function testFromEntitiesToParentDeleteRequests_throwsRequestEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntitiesToDeleteRequests_throwsRequestEntityException($this->entities);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToParentDeleteRequests($this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }
}
