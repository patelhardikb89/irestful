<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Partials\Exceptions\RequestPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\OrderingHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityPartialSetRetrieverCriteriaAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityPartialSetRetrieverCriteriaHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestPartialSetAdapter;

final class ConcreteRequestPartialSetAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityPartialSetRetrieverCriteriaAdapterMock;
    private $entityPartialSetRetrieverCriteriaMock;
    private $orderingMock;
    private $orderingNames;
    private $orderByQuery;
    private $orderByQueryASC;
    private $criteria;
    private $containerName;
    private $index;
    private $amount;
    private $adapter;
    private $entityPartialSetRetrieverCriteriaAdapterHelper;
    private $entityPartialSetRetrieverCriteriaHelper;
    private $orderingHelper;
    public function setUp() {

        $this->entityPartialSetRetrieverCriteriaAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\EntityPartialSetRetrieverCriteriaAdapter');
        $this->entityPartialSetRetrieverCriteriaMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');

        $this->orderingNames = [
            'created_on',
            'title'
        ];

        $this->orderByQuery = ' order by created_on, title desc';
        $this->orderByQueryASC = ' order by created_on, title asc';

        $this->containerName = 'my_container';
        $this->index = rand(0, 100);
        $this->amount = rand(1, 100);

        $this->criteria = [
            'container' => $this->containerName,
            'index' => $this->index,
            'amount' => $this->amount
        ];



        $this->adapter = new ConcreteRequestPartialSetAdapter($this->entityPartialSetRetrieverCriteriaAdapterMock);

        $this->entityPartialSetRetrieverCriteriaAdapterHelper = new EntityPartialSetRetrieverCriteriaAdapterHelper($this, $this->entityPartialSetRetrieverCriteriaAdapterMock);
        $this->entityPartialSetRetrieverCriteriaHelper = new EntityPartialSetRetrieverCriteriaHelper($this, $this->entityPartialSetRetrieverCriteriaMock);
        $this->orderingHelper = new OrderingHelper($this, $this->orderingMock);

    }

    public function tearDown() {

    }

    public function testFromEntityPartialSetRetrieverCriteriaToRequest_Success() {

        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetAmount_Success($this->amount);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);

        $request = $this->adapter->fromEntityPartialSetRetrieverCriteriaToRequest($this->entityPartialSetRetrieverCriteriaMock);

        $this->assertEquals([
            'query' => 'select * from '.$this->containerName.' limit '.$this->index.','.$this->amount.';'
        ], $request);

    }

    public function testFromEntityPartialSetRetrieverCriteriaToRequest_withOrdering_Success() {

        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetAmount_Success($this->amount);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsHasOrdering_Success(true);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetOrdering_Success($this->orderingMock);
        $this->orderingHelper->expectsGetNames_Success($this->orderingNames);
        $this->orderingHelper->expectsIsAscending_Success(true);

        $request = $this->adapter->fromEntityPartialSetRetrieverCriteriaToRequest($this->entityPartialSetRetrieverCriteriaMock);

        $this->assertEquals([
            'query' => 'select * from '.$this->containerName.$this->orderByQueryASC.' limit '.$this->index.','.$this->amount.';'
        ], $request);

    }

    public function testFromDataToEntityPartialSetRequest_Success() {

        $this->entityPartialSetRetrieverCriteriaAdapterHelper->expectsFromDataToEntityPartialSetRetrieverCriteria_Success($this->entityPartialSetRetrieverCriteriaMock, $this->criteria);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetIndex_Success($this->index);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetAmount_Success($this->amount);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsHasOrdering_Success(false);

        $request = $this->adapter->fromDataToEntityPartialSetRequest($this->criteria);

        $this->assertEquals([
            'query' => 'select * from '.$this->containerName.' limit '.$this->index.','.$this->amount.';'
        ], $request);

    }

    public function testFromDataToEntityPartialSetRequest_throwsEntityPartialSetException_throwsRequestPartialSetException() {

        $this->entityPartialSetRetrieverCriteriaAdapterHelper->expectsFromDataToEntityPartialSetRetrieverCriteria_throwsEntityPartialSetException($this->criteria);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRequest($this->criteria);

        } catch (RequestPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityPartialSetRetrieverCriteriaToTotalAmountRequest_Success() {
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);

        $request = $this->adapter->fromEntityPartialSetRetrieverCriteriaToTotalAmountRequest($this->entityPartialSetRetrieverCriteriaMock);

        $this->assertEquals([
            'query' => 'select count(1) as amount from '.$this->containerName
        ], $request);
    }

    public function testFromDataToEntityPartialSetTotalAmountRequest_Success() {

        $this->entityPartialSetRetrieverCriteriaAdapterHelper->expectsFromDataToEntityPartialSetRetrieverCriteria_Success($this->entityPartialSetRetrieverCriteriaMock, $this->criteria);
        $this->entityPartialSetRetrieverCriteriaHelper->expectsGetContainerName_Success($this->containerName);

        $request = $this->adapter->fromDataToEntityPartialSetTotalAmountRequest($this->criteria);

        $this->assertEquals([
            'query' => 'select count(1) as amount from '.$this->containerName
        ], $request);
    }

    public function testFromDataToEntityPartialSetTotalAmountRequest_throwsEntityPartialSetException_throwsRequestPartialSetException() {

        $this->entityPartialSetRetrieverCriteriaAdapterHelper->expectsFromDataToEntityPartialSetRetrieverCriteria_throwsEntityPartialSetException($this->criteria);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetTotalAmountRequest($this->criteria);

        } catch (RequestPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
