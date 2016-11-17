<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Repositories\ConcreteSubEntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityHelper;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Objects\UuidHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Exceptions\SubEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteSubEntities;

final class ConcreteSubEntityRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $entityRepositoryMock;
    private $entityAdapterMock;
    private $entityMock;
    private $uuidMock;
    private $subEntities;
    private $containerNames;
    private $firstUuid;
    private $secondUuid;
    private $firstCriteria;
    private $secondCriteria;
    private $filters;
    private $repository;
    private $entityRepositoryHelper;
    private $entityAdapterHelper;
    private $entityHelper;
    private $uuidHelper;
    public function setUp() {
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

        $this->subEntities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->containerNames = [
            'first',
            'second'
        ];

        $this->firstUuid = '73508cf2-c4fd-4ee4-a27b-385553dad453';
        $this->secondUuid = 'e7c1dcb1-8a14-4ac7-b384-a3e10ca087bd';

        $this->firstCriteria = [
            'container' => 'first',
            'uuid' => $this->firstUuid
        ];

        $this->secondCriteria = [
            'container' => 'second',
            'uuid' => $this->secondUuid
        ];

        $this->filters = [
            'entity' => $this->entityMock,
            'more' => 'filters'
        ];

        $this->repository = new ConcreteSubEntityRepository($this->entityRepositoryMock, $this->entityAdapterMock);

        $this->entityRepositoryHelper = new EntityRepositoryHelper($this, $this->entityRepositoryMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
        $this->entityHelper = new EntityHelper($this, $this->entityMock);
        $this->uuidHelper = new UuidHelper($this, $this->uuidMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_withoutSubEntities_Success() {

        $this->entityAdapterHelper->expectsFromEntityToSubEntities_Success([], $this->entityMock);

        $subEntities = $this->repository->retrieve($this->entityMock);

        $this->assertNull($subEntities);

    }

    public function testRetrieve_twoExists_Success() {

        $this->entityAdapterHelper->expectsFromEntityToSubEntities_Success($this->subEntities, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->subEntities);

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGetHumanReadable_multiple_Success([$this->firstUuid, $this->secondUuid]);
        $this->entityRepositoryHelper->expectsExists_multiple_Success([true, true], [$this->firstCriteria, $this->secondCriteria]);

        $subEntities = $this->repository->retrieve($this->entityMock);

        $this->assertEquals(new ConcreteSubEntities($this->subEntities), $subEntities);

    }

    public function testRetrieve_oneExists_Success() {

        $this->entityAdapterHelper->expectsFromEntityToSubEntities_Success($this->subEntities, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->subEntities);

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGetHumanReadable_multiple_Success([$this->firstUuid, $this->secondUuid]);
        $this->entityRepositoryHelper->expectsExists_multiple_Success([true, false], [$this->firstCriteria, $this->secondCriteria]);

        $subEntities = $this->repository->retrieve($this->entityMock);

        $this->assertEquals(new ConcreteSubEntities([$this->entityMock], [$this->entityMock]), $subEntities);

    }

    public function testRetrieve_zeroExists_Success() {

        $this->entityAdapterHelper->expectsFromEntityToSubEntities_Success($this->subEntities, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->subEntities);

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGetHumanReadable_multiple_Success([$this->firstUuid, $this->secondUuid]);
        $this->entityRepositoryHelper->expectsExists_multiple_Success([false, false], [$this->firstCriteria, $this->secondCriteria]);

        $subEntities = $this->repository->retrieve($this->entityMock);

        $this->assertEquals(new ConcreteSubEntities(null, $this->subEntities), $subEntities);

    }

    public function testRetrieve_throwsEntityException_throwsSubEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToSubEntities_Success($this->subEntities, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->subEntities);

        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->firstUuid);
        $this->entityRepositoryHelper->expectsExists_throwsEntityException($this->firstCriteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->entityMock);

        } catch (SubEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
