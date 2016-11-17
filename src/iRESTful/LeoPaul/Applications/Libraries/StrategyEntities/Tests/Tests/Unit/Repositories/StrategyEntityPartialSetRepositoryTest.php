<?php
namespace iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Applications\Libraries\StrategyEntities\Infrastructure\Repositories\StrategyEntityPartialSetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityPartialSetRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityPartialSetRetrieverCriteriaHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityPartialSetRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class StrategyEntityPartialSetRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetRetrieverCriteriaAdapterMock;
    private $entityPartialSetRetrieverCriteriaMock;
    private $entityPartialSetRepositoryMock;
    private $entityPartialSetMock;
    private $criteria;
    private $containerName;
    private $mapper;
    private $repository;
    private $entityPartialSetRetrieverCriteriaAdapterHelper;
    private $entityPartialSetRetrieverCriteriaHelper;
    private $entityPartialSetRepositoryHelper;
    public function setUp() {
        $this->entityPartialSetRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\EntityPartialSetRetrieverCriteriaAdapter');
        $this->entityPartialSetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria');
        $this->entityPartialSetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository');
        $this->entityPartialSetMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet');

        $this->criteria = [
            'some' => 'criteria'
        ];

        $this->containerName = 'my_container';

        $this->mapper = [
            $this->containerName => $this->entityPartialSetRepositoryMock
        ];

        $this->repository = new StrategyEntityPartialSetRepository($this->entityPartialSetRetrieverCriteriaAdapterMock, $this->mapper);

        $this->entityPartialSetRetrieverCriteriaAdapterHelper = new EntityPartialSetRetrieverCriteriaAdapterHelper($this, $this->entityPartialSetRetrieverCriteriaAdapterMock);
        $this->entityPartialSetRetrieverCriteriaHelper = new EntityPartialSetRetrieverCriteriaHelper($this, $this->entityPartialSetRetrieverCriteriaMock);
        $this->entityPartialSetRepositoryHelper = new EntityPartialSetRepositoryHelper($this, $this->entityPartialSetRepositoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->entityPartialSetRetrieverCriteriaAdapterHelper->expectsFromDataToEntityPartialSetRetrieverCriteria_Success($this->entityPartialSetRetrieverCriteriaMock, $this->criteria);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityPartialSetRepositoryHelper->expectsRetrieve_Success($this->entityPartialSetMock, $this->criteria);

        $entityPartialSet = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entityPartialSetMock, $entityPartialSet);

    }

    public function testCreate_throwsEntityPartialSetException() {

        $this->entityPartialSetRetrieverCriteriaAdapterHelper->expectsFromDataToEntityPartialSetRetrieverCriteria_Success($this->entityPartialSetRetrieverCriteriaMock, $this->criteria);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityPartialSetRepositoryHelper->expectsRetrieve_throwsEntityPartialSetException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_containerIsNotInMapper_throwsEntityPartialSetException() {

        $this->entityPartialSetRetrieverCriteriaAdapterHelper->expectsFromDataToEntityPartialSetRetrieverCriteria_Success($this->entityPartialSetRetrieverCriteriaMock, $this->criteria);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success('some_container');

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withBadCriteria_throwsEntityPartialSetException() {

        $this->entityPartialSetRetrieverCriteriaAdapterHelper->expectsFromDataToEntityPartialSetRetrieverCriteria_throwsEntityPartialSetException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
