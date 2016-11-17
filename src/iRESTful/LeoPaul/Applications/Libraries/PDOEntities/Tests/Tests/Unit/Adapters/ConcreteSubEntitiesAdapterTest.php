<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\RequestEntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\SubEntitiesHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteSubEntitiesAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Subs\Exceptions\RequestSubEntitiesException;

final class ConcreteSubEntitiesAdapterTest extends \PHPUnit_Framework_TestCase {
    private $requestEntityAdapterMock;
    private $subEntitiesMock;
    private $entityMock;
    private $existingEntities;
    private $newEntities;
    private $updateRequests;
    private $insertRequests;
    private $adapter;
    private $requestEntityAdapterHelper;
    private $subEntitiesHelper;
    public function setUp() {
        $this->requestEntityAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter');
        $this->subEntitiesMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->existingEntities = [
            $this->entityMock
        ];

        $this->newEntities = [
            $this->entityMock,
            $this->entityMock,
            $this->entityMock
        ];

        $this->updateRequests = ['one' => 'update request'];

        $this->insertRequests = [
            'first' => 'insert request',
            'second' => 'insert request'
        ];

        $this->adapter = new ConcreteSubEntitiesAdapter($this->requestEntityAdapterMock);

        $this->requestEntityAdapterHelper = new RequestEntityAdapterHelper($this, $this->requestEntityAdapterMock);
        $this->subEntitiesHelper = new SubEntitiesHelper($this, $this->subEntitiesMock);
    }

    public function tearDown() {

    }

    public function testFromSubEntitiesToRequests_Success() {

        $this->subEntitiesHelper->expectsHasExistingEntities_Success(false);
        $this->subEntitiesHelper->expectsHasNewEntities_Success(false);

        $requests = $this->adapter->fromSubEntitiesToRequests($this->subEntitiesMock);

        $this->assertEquals([
            'insert' => [],
            'update' => []
        ], $requests);

    }

    public function testFromSubEntitiesToRequests_withExistingEntities_Success() {

        $this->subEntitiesHelper->expectsHasExistingEntities_Success(true);
        $this->subEntitiesHelper->expectsGetExistingEntities_Success($this->existingEntities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToUpdateRequests_Success($this->updateRequests, $this->existingEntities, $this->existingEntities);

        $this->subEntitiesHelper->expectsHasNewEntities_Success(false);

        $requests = $this->adapter->fromSubEntitiesToRequests($this->subEntitiesMock);

        $this->assertEquals([
            'insert' => [],
            'update' => $this->updateRequests
        ], $requests);

    }

    public function testFromSubEntitiesToRequests_withNewEntities_Success() {

        $this->subEntitiesHelper->expectsHasExistingEntities_Success(false);
        $this->subEntitiesHelper->expectsHasNewEntities_Success(true);
        $this->subEntitiesHelper->expectsGetNewEntities_Success($this->newEntities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToInsertRequests_Success($this->insertRequests, $this->newEntities);

        $requests = $this->adapter->fromSubEntitiesToRequests($this->subEntitiesMock);

        $this->assertEquals([
            'insert' => $this->insertRequests,
            'update' => []
        ], $requests);

    }

    public function testFromSubEntitiesToRequests_withExistingEntities_withNewEntities_Success() {

        $this->subEntitiesHelper->expectsHasExistingEntities_Success(true);
        $this->subEntitiesHelper->expectsGetExistingEntities_Success($this->existingEntities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToUpdateRequests_Success($this->updateRequests, $this->existingEntities, $this->existingEntities);

        $this->subEntitiesHelper->expectsHasNewEntities_Success(true);
        $this->subEntitiesHelper->expectsGetNewEntities_Success($this->newEntities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToInsertRequests_Success($this->insertRequests, $this->newEntities);

        $requests = $this->adapter->fromSubEntitiesToRequests($this->subEntitiesMock);

        $this->assertEquals([
            'insert' => $this->insertRequests,
            'update' => $this->updateRequests
        ], $requests);

    }

    public function testFromSubEntitiesToRequests_withNewEntities_throwsRequestEntityException_throwsRequestSubEntitiesException() {

        $this->subEntitiesHelper->expectsHasExistingEntities_Success(false);
        $this->subEntitiesHelper->expectsHasNewEntities_Success(true);
        $this->subEntitiesHelper->expectsGetNewEntities_Success($this->newEntities);
        $this->requestEntityAdapterHelper->expectsFromEntitiesToInsertRequests_throwsRequestEntityException($this->newEntities);

        $asserted = false;
        try {

            $this->adapter->fromSubEntitiesToRequests($this->subEntitiesMock);

        } catch (RequestSubEntitiesException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
