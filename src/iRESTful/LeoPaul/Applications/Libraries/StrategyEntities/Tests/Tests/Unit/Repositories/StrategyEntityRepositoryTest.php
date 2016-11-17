<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories\StrategyEntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityRetrieverCriteriaHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class StrategyEntityRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $entityRetrieverCriteriaAdapterMock;
    private $entityRetrieverCriteriaMock;
    private $entityRepositoryMock;
    private $entityMock;
    private $criteria;
    private $containerName;
    private $mapper;
    private $repository;
    private $entityRetrieverCriteriaAdapterHelper;
    private $entityRetrieverCriteriaHelper;
    private $entityRepositoryHelper;
    public function setUp() {
        $this->entityRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters\EntityRetrieverCriteriaAdapter');
        $this->entityRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria');
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->criteria = [
            'some' => 'criteria'
        ];

        $this->containerName = 'my_container';

        $this->mapper = [
            $this->containerName => $this->entityRepositoryMock
        ];

        $this->repository = new StrategyEntityRepository($this->entityRetrieverCriteriaAdapterMock, $this->mapper);

        $this->entityRetrieverCriteriaAdapterHelper = new EntityRetrieverCriteriaAdapterHelper($this, $this->entityRetrieverCriteriaAdapterMock);
        $this->entityRetrieverCriteriaHelper = new EntityRetrieverCriteriaHelper($this, $this->entityRetrieverCriteriaMock);
        $this->entityRepositoryHelper = new EntityRepositoryHelper($this, $this->entityRepositoryMock);
    }

    public function tearDown() {

    }

    public function testExists_Success() {

        $this->entityRetrieverCriteriaAdapterHelper->expectsFromDataToRetrieverCriteria_Success($this->entityRetrieverCriteriaMock, $this->criteria);
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRepositoryHelper->expectsExists_Success(false, $this->criteria);

        $hasEntity = $this->repository->exists($this->criteria);

        $this->assertFalse($hasEntity);

    }

    public function testRetrieve_Success() {

        $this->entityRetrieverCriteriaAdapterHelper->expectsFromDataToRetrieverCriteria_Success($this->entityRetrieverCriteriaMock, $this->criteria);
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entityMock, $this->criteria);

        $entity = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entityMock, $entity);

    }

    public function testRetrieve_throwsEntityException() {

        $this->entityRetrieverCriteriaAdapterHelper->expectsFromDataToRetrieverCriteria_Success($this->entityRetrieverCriteriaMock, $this->criteria);
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRepositoryHelper->expectsRetrieve_throwsEntityException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_containerNameIsNotInMapper_throwsEntityException() {

        $this->entityRetrieverCriteriaAdapterHelper->expectsFromDataToRetrieverCriteria_Success($this->entityRetrieverCriteriaMock, $this->criteria);
        $this->entityRetrieverCriteriaHelper->expectsGetContainerName_Success('another_container');

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withBadCriteria_throwsEntityException() {

        $this->entityRetrieverCriteriaAdapterHelper->expectsFromDataToRetrieverCriteria_throwsEntityException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
