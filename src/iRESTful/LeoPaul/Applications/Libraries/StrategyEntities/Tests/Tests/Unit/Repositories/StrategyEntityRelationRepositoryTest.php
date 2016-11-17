<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityRelationRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityRelationRetrieverCriteriaHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityRelationRepositoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories\StrategyEntityRelationRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class StrategyEntityRelationRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRetrieverCriteriaAdapterMock;
    private $entityRelationRetrieverCriteriaMock;
    private $entityRelationRepositoryMock;
    private $entityMock;
    private $criteria;
    private $containerName;
    private $mapper;
    private $entities;
    private $repository;
    private $entityRelationRetrieverCriteriaAdapterHelper;
    private $entityRelationRetrieverCriteriaHelper;
    private $entityRelationRepositoryHelper;
    public function setUp() {
        $this->entityRelationRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters\EntityRelationRetrieverCriteriaAdapter');
        $this->entityRelationRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria');
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->criteria = [
            'some' => 'criteria'
        ];

        $this->containerName = 'my_container';
        $this->mapper = [
            $this->containerName => $this->entityRelationRepositoryMock
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->repository = new StrategyEntityRelationRepository($this->entityRelationRetrieverCriteriaAdapterMock, $this->mapper);

        $this->entityRelationRetrieverCriteriaAdapterHelper = new EntityRelationRetrieverCriteriaAdapterHelper($this, $this->entityRelationRetrieverCriteriaAdapterMock);
        $this->entityRelationRetrieverCriteriaHelper = new EntityRelationRetrieverCriteriaHelper($this, $this->entityRelationRetrieverCriteriaMock);
        $this->entityRelationRepositoryHelper = new EntityRelationRepositoryHelper($this, $this->entityRelationRepositoryMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->entityRelationRetrieverCriteriaAdapterHelper->expectsFromDataToEntityRelationRetrieverCriteria_Success($this->entityRelationRetrieverCriteriaMock, $this->criteria);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterContainerName_Success($this->containerName);
        $this->entityRelationRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteria);

        $entities = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entities, $entities);

    }

    public function testRetrieve_throwsEntityRelationException() {

        $this->entityRelationRetrieverCriteriaAdapterHelper->expectsFromDataToEntityRelationRetrieverCriteria_Success($this->entityRelationRetrieverCriteriaMock, $this->criteria);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterContainerName_Success($this->containerName);
        $this->entityRelationRepositoryHelper->expectsRetrieve_throwsEntityRelationException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_containerNameIsNotInMapper_throwsEntityRelationException() {

        $this->entityRelationRetrieverCriteriaAdapterHelper->expectsFromDataToEntityRelationRetrieverCriteria_Success($this->entityRelationRetrieverCriteriaMock, $this->criteria);
        $this->entityRelationRetrieverCriteriaHelper->expectsGetMasterContainerName_Success('another_container');

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withBadCriteria_throwsEntityRelationException() {

        $this->entityRelationRetrieverCriteriaAdapterHelper->expectsFromDataToEntityRelationRetrieverCriteria_throwsEntityRelationException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
