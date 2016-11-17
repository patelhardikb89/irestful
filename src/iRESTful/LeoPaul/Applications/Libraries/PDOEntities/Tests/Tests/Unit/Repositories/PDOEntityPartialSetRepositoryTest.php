<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories\PDOEntityPartialSetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityPartialSetAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Repositories\PDORepositoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\PDOAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Factories\PDOAdapterFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\OrderingHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\RequestPartialSetAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityPartialSetRetrieverCriteriaHelper;

final class PDOEntityPartialSetRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $requestPartialSetAdapterMock;
    private $entityPartialSetRetrieverCriteriaMock;
    private $entityPartialSetAdapterMock;
    private $entityPartialSetMock;
    private $pdoRepositoryMock;
    private $pdoMock;
    private $pdoAdapterFactoryMock;
    private $pdoAdapterMock;
    private $entityMock;
    private $orderingMock;
    private $request;
    private $orderingNames;
    private $entities;
    private $containerName;
    private $criteria;
    private $index;
    private $amount;
    private $totalAmount;
    private $totalAmountQuery;
    private $query;
    private $queryWithOrderByASC;
    private $queryWithOrderByDESC;
    private $queryAmount;
    private $entityPartialSetData;
    private $entityPartialSetDataWithoutEntities;
    private $repository;
    private $requestPartialSetAdapterHelper;
    private $entityPartialSetRetrieverCriteriaHelper;
    private $entityPartialSetAdapterHelper;
    private $orderingHelper;
    private $pdoRepositoryHelper;
    private $pdoAdapterFactoryHelper;
    private $pdoAdapterHelper;
    public function setUp() {
        $this->requestPartialSetAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Partials\Adapters\RequestPartialSetAdapter');
        $this->entityPartialSetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria');
        $this->entityPartialSetAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter');
        $this->entityPartialSetMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet');
        $this->pdoRepositoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository');
        $this->pdoMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO');
        $this->pdoAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Factories\PDOAdapterFactory');
        $this->pdoAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');

        $this->orderingNames = [
            'created_on',
            'title'
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->containerName = 'my_container';

        $this->index = rand(0, 100);
        $this->amount = count($this->entities);
        $this->totalAmount = $this->index + $this->amount + rand(1, 500);

        $this->criteria = [
            'container' => $this->containerName,
            'index' => $this->index,
            'amount' => $this->amount
        ];

        $this->query = 'select * from '.$this->containerName.' limit '.$this->index.','.$this->amount.';';
        $this->queryWithOrderByASC = 'select * from '.$this->containerName.' order by created_on, title asc limit '.$this->index.','.$this->amount.';';
        $this->queryWithOrderByDESC = 'select * from '.$this->containerName.' order by created_on, title desc limit '.$this->index.','.$this->amount.';';

        $this->queryAmount = 'select count(1) as amount from '.$this->containerName;

        $this->request = [
            'query' => $this->query,
            'criteria' => $this->entityPartialSetRetrieverCriteriaMock
        ];

        $this->entityPartialSetData = [
            'index' => $this->index,
            'total_amount' => $this->totalAmount,
            'entities' => $this->entities
        ];

        $this->entityPartialSetDataWithoutEntities = [
            'index' => $this->index,
            'total_amount' => $this->totalAmount,
            'entities' => null
        ];

        $this->repository = new PDOEntityPartialSetRepository($this->requestPartialSetAdapterMock, $this->entityPartialSetAdapterMock, $this->pdoRepositoryMock, $this->pdoAdapterFactoryMock);

        $this->requestPartialSetAdapterHelper = new RequestPartialSetAdapterHelper($this, $this->requestPartialSetAdapterMock);
        $this->entityPartialSetRetrieverCriteriaHelper = new EntityPartialSetRetrieverCriteriaHelper($this, $this->entityPartialSetRetrieverCriteriaMock);
        $this->entityPartialSetAdapterHelper = new EntityPartialSetAdapterHelper($this, $this->entityPartialSetAdapterMock);
        $this->orderingHelper = new OrderingHelper($this, $this->orderingMock);
        $this->pdoRepositoryHelper = new PDORepositoryHelper($this, $this->pdoRepositoryMock);
        $this->pdoAdapterFactoryHelper = new PDOAdapterFactoryHelper($this, $this->pdoAdapterFactoryMock);
        $this->pdoAdapterHelper = new PDOAdapterHelper($this, $this->pdoAdapterMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->pdoAdapterFactoryHelper->expectsCreate_Success($this->pdoAdapterMock);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetRequest_Success($this->request, $this->criteria);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetTotalAmountRequest_Success(['query' => $this->queryAmount], $this->criteria);

        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_Success($this->entities, $this->pdoMock, $this->containerName);

        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, ['query' => $this->queryAmount]);
        $this->pdoAdapterHelper->expectsFromPDOToResults_Success(['amount' => $this->totalAmount], $this->pdoMock, $this->containerName);

        $this->entityPartialSetAdapterHelper->expectsFromDataToEntityPartialSet_Success($this->entityPartialSetMock, $this->entityPartialSetData);

        $entityPartialSet = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entityPartialSetMock, $entityPartialSet);

    }

    public function testRetrieve_withoutEntities_Success() {

        $this->pdoAdapterFactoryHelper->expectsCreate_Success($this->pdoAdapterMock);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetRequest_Success($this->request, $this->criteria);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetTotalAmountRequest_Success(['query' => $this->queryAmount], $this->criteria);

        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_withoutResults_Success($this->pdoMock, $this->containerName);

        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, ['query' => $this->queryAmount]);
        $this->pdoAdapterHelper->expectsFromPDOToResults_Success(['amount' => $this->totalAmount], $this->pdoMock, $this->containerName);

        $this->entityPartialSetAdapterHelper->expectsFromDataToEntityPartialSet_Success($this->entityPartialSetMock, $this->entityPartialSetDataWithoutEntities);

        $entityPartialSet = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entityPartialSetMock, $entityPartialSet);

    }

    public function testRetrieve_withoutEntities_throwsEntityPartialSetException_throwsEntityPartialSetException() {

        $this->pdoAdapterFactoryHelper->expectsCreate_Success($this->pdoAdapterMock);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetRequest_Success($this->request, $this->criteria);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetTotalAmountRequest_Success(['query' => $this->queryAmount], $this->criteria);

        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_withoutResults_Success($this->pdoMock, $this->containerName);

        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, ['query' => $this->queryAmount]);
        $this->pdoAdapterHelper->expectsFromPDOToResults_Success(['amount' => $this->totalAmount], $this->pdoMock, $this->containerName);

        $this->entityPartialSetAdapterHelper->expectsFromDataToEntityPartialSet_throwsEntityPartialSetException($this->entityPartialSetDataWithoutEntities);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withoutEntities_withoutAmountFromTotalAmountQuery_throwsEntityPartialSetException() {

        $this->pdoAdapterFactoryHelper->expectsCreate_Success($this->pdoAdapterMock);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetRequest_Success($this->request, $this->criteria);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetTotalAmountRequest_Success(['query' => $this->queryAmount], $this->criteria);

        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_withoutResults_Success($this->pdoMock, $this->containerName);

        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, ['query' => $this->queryAmount]);
        $this->pdoAdapterHelper->expectsFromPDOToResults_Success([], $this->pdoMock, $this->containerName);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withoutEntities_throwsPDOException_internally_throwsEntityPartialSetException() {

        $this->pdoAdapterFactoryHelper->expectsCreate_Success($this->pdoAdapterMock);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetRequest_Success($this->request, $this->criteria);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetTotalAmountRequest_Success(['query' => $this->queryAmount], $this->criteria);

        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_withoutResults_Success($this->pdoMock, $this->containerName);

        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, ['query' => $this->queryAmount]);
        $this->pdoAdapterHelper->expectsFromPDOToResults_throwsPDOException($this->pdoMock, $this->containerName);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withoutEntities_throwsPDOException_throwsEntityPartialSetException() {

        $this->pdoAdapterFactoryHelper->expectsCreate_Success($this->pdoAdapterMock);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetRequest_Success($this->request, $this->criteria);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetTotalAmountRequest_Success(['query' => $this->queryAmount], $this->criteria);

        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_withoutResults_Success($this->pdoMock, $this->containerName);

        $this->pdoRepositoryHelper->expectsFetchFirst_throwsPDOException(['query' => $this->queryAmount]);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsRequestPartialSetException_throwsEntityPartialSetException() {

        $this->pdoAdapterFactoryHelper->expectsCreate_Success($this->pdoAdapterMock);
        $this->requestPartialSetAdapterHelper->expectsFromDataToEntityPartialSetRequest_throwsRequestPartialSetException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withoutIndexInCriteria_throwsEntityPartialSetException() {

        unset($this->criteria['index']);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withoutContainerInCriteria_throwsEntityPartialSetException() {

        unset($this->criteria['container']);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
