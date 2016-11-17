<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories\StrategyEntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntitySetRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntitySetRetrieverCriteriaHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntitySetRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class StrategyEntitySetRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $entitySetRetrieverCriteriaAdapterMock;
    private $entitySetRetrieverCriteriaMock;
    private $entitySetRepositoryMock;
    private $entityMock;
    private $criteria;
    private $entities;
    private $containerName;
    private $mapper;
    private $repository;
    private $entitySetRetrieverCriteriaAdapterHelper;
    private $entitySetRetrieverCriteriaHelper;
    private $entitySetRepositoryHelper;
    public function setUp() {
        $this->entitySetRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\EntitySetRetrieverCriteriaAdapter');
        $this->entitySetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria');
        $this->entitySetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\EntitySetRepository');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->criteria = [
            'some' => 'criteria'
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->containerName = 'my_container';

        $this->mapper = [
            $this->containerName => $this->entitySetRepositoryMock
        ];

        $this->repository = new StrategyEntitySetRepository($this->entitySetRetrieverCriteriaAdapterMock, $this->mapper);

        $this->entitySetRetrieverCriteriaAdapterHelper = new EntitySetRetrieverCriteriaAdapterHelper($this, $this->entitySetRetrieverCriteriaAdapterMock);
        $this->entitySetRetrieverCriteriaHelper = new EntitySetRetrieverCriteriaHelper($this, $this->entitySetRetrieverCriteriaMock);
        $this->entitySetRepositoryHelper = new EntitySetRepositoryHelper($this, $this->entitySetRepositoryMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->entitySetRetrieverCriteriaAdapterHelper->expectsFromDataToEntitySetRetrieverCriteria_Success($this->entitySetRetrieverCriteriaMock, $this->criteria);
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteria);

        $entities = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entities, $entities);

    }

    public function testRetrieve_throwsEntitySetException() {

        $this->entitySetRetrieverCriteriaAdapterHelper->expectsFromDataToEntitySetRetrieverCriteria_Success($this->entitySetRetrieverCriteriaMock, $this->criteria);
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entitySetRepositoryHelper->expectsRetrieve_throwsEntitySetException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withContainerNotInMapper_throwsEntitySetException() {

        $this->entitySetRetrieverCriteriaAdapterHelper->expectsFromDataToEntitySetRetrieverCriteria_Success($this->entitySetRetrieverCriteriaMock, $this->criteria);
        $this->entitySetRetrieverCriteriaHelper->expectsGetContainerName_Success('some_container');

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withBadCriteria_throwsEntitySetException() {

        $this->entitySetRetrieverCriteriaAdapterHelper->expectsFromDataToEntitySetRetrieverCriteria_throwsEntitySetException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
