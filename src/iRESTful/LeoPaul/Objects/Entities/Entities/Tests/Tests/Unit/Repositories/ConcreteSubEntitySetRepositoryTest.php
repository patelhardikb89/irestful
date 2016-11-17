<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Repositories\ConcreteSubEntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\SubEntityRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Exceptions\SubEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\SubEntitiesHelper;

final class ConcreteSubEntitySetRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $subEntityRepositoryMock;
    private $subEntitiesMock;
    private $entityMock;
    private $entities;
    private $firstSubEntities;
    private $secondSubEntities;
    private $subEntities;
    private $repository;
    private $subEntityRepositoryHelper;
    private $subEntitiesHelper;
    public function setUp() {

        $this->subEntityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories\SubEntityRepository');
        $this->subEntitiesMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->repository = new ConcreteSubEntitySetRepository($this->subEntityRepositoryMock);

        $this->subEntityRepositoryHelper = new SubEntityRepositoryHelper($this, $this->subEntityRepositoryMock);
        $this->subEntitiesHelper = new SubEntitiesHelper($this, $this->subEntitiesMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->subEntityRepositoryHelper->expectsRetrieve_multiple_Success(
            [$this->subEntitiesMock, $this->subEntitiesMock],
            [$this->entityMock, $this->entityMock]
        );

        $this->subEntitiesHelper->expectsMerge_Success($this->subEntitiesMock, $this->subEntitiesMock);

        $subEntities = $this->repository->retrieve($this->entities);

        $this->assertEquals($this->subEntitiesMock, $subEntities);

    }

    public function testRetrieve_withoutEntities_Success() {

        $subEntities = $this->repository->retrieve([]);

        $this->assertNull($subEntities);

    }

    public function testRetrieve_withThreeEntities_firstSubEntitiesIsNull_Success() {

        $this->subEntityRepositoryHelper->expectsRetrieve_multiple_Success(
            [null, $this->subEntitiesMock, $this->subEntitiesMock],
            [$this->entityMock, $this->entityMock, $this->entityMock]
        );

        $this->subEntitiesHelper->expectsMerge_Success($this->subEntitiesMock, $this->subEntitiesMock);

        $subEntities = $this->repository->retrieve([$this->entityMock, $this->entityMock, $this->entityMock]);

        $this->assertEquals($this->subEntitiesMock, $subEntities);

    }

    public function testRetrieve_secondSubEntitiesIsNull_Success() {

        $this->subEntityRepositoryHelper->expectsRetrieve_multiple_Success(
            [$this->subEntitiesMock, null],
            [$this->entityMock, $this->entityMock]
        );

        $subEntities = $this->repository->retrieve($this->entities);

        $this->assertEquals($this->subEntitiesMock, $subEntities);

    }

    public function testRetrieve_withOneEntity_withNullSubEntities_Success() {

        $this->subEntityRepositoryHelper->expectsRetrieve_returnsNull_Success($this->entityMock);

        $subEntities = $this->repository->retrieve([$this->entityMock]);

        $this->assertNull($subEntities);

    }

    public function testRetrieve_throwsSubEntityException() {

        $this->subEntityRepositoryHelper->expectsRetrieve_throwsSubEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->repository->retrieve($this->entities);

        } catch (SubEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
