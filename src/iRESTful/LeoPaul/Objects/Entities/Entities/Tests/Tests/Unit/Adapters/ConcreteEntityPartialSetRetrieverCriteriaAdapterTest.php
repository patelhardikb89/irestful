<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityPartialSetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\OrderingAdapterHelper;

final class ConcreteEntityPartialSetRetrieverCriteriaAdapterTest extends \PHPUnit_Framework_TestCase {
    private $orderingAdapterMock;
    private $orderingMock;
    private $containerName;
    private $index;
    private $amount;
    private $orderingData;
    private $data;
    private $dataWithOrdering;
    private $adapter;
    private $orderingAdapterHelper;
    public function setUp() {

        $this->orderingAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');

        $this->container = 'my_container';
        $this->index = rand(0, 500);
        $this->amount = rand(1, 500);

        $this->orderingData = [
            'names' => ['slug', 'created_on'],
            'is_ascending' => false
        ];

        $this->data = [
            'container' => 'my_container',
            'index' => (string) $this->index,
            'amount' => (string) $this->amount
        ];

        $this->dataWithOrdering = [
            'container' => 'my_container',
            'index' => (string) $this->index,
            'amount' => (string) $this->amount,
            'ordering' => $this->orderingData
        ];

        $this->adapter = new ConcreteEntityPartialSetRetrieverCriteriaAdapter($this->orderingAdapterMock);

        $this->orderingAdapterHelper = new OrderingAdapterHelper($this, $this->orderingAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityPartialSetRetrieverCriteria_Success() {

        $partialSetRetrieverCriteria = $this->adapter->fromDataToEntityPartialSetRetrieverCriteria($this->data);

        $this->assertEquals($this->container, $partialSetRetrieverCriteria->getContainerName());
        $this->assertEquals($this->index, $partialSetRetrieverCriteria->getIndex());
        $this->assertEquals($this->amount, $partialSetRetrieverCriteria->getAmount());
        $this->assertFalse($partialSetRetrieverCriteria->hasOrdering());
        $this->assertNull($partialSetRetrieverCriteria->getOrdering());

    }

    public function testFromDataToEntityPartialSetRetrieverCriteria_withOrdering_Success() {

        $this->orderingAdapterHelper->expectsFromDataToOrdering_Success($this->orderingMock, $this->orderingData);

        $partialSetRetrieverCriteria = $this->adapter->fromDataToEntityPartialSetRetrieverCriteria($this->dataWithOrdering);

        $this->assertEquals($this->container, $partialSetRetrieverCriteria->getContainerName());
        $this->assertEquals($this->index, $partialSetRetrieverCriteria->getIndex());
        $this->assertEquals($this->amount, $partialSetRetrieverCriteria->getAmount());
        $this->assertTrue($partialSetRetrieverCriteria->hasOrdering());
        $this->assertEquals($this->orderingMock, $partialSetRetrieverCriteria->getOrdering());

    }

    public function testFromDataToEntityPartialSetRetrieverCriteria_withOrdering_throwsOrderingException_throwsEntityPartialSetException() {

        $this->orderingAdapterHelper->expectsFromDataToOrdering_throwsOrderingException($this->orderingData);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRetrieverCriteria($this->dataWithOrdering);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetRetrieverCriteria_withoutContainerName_throwsEntityPartialSetException() {

        unset($this->data['container']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRetrieverCriteria($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetRetrieverCriteria_withoutIndex_throwsEntityPartialSetException() {

        unset($this->data['index']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRetrieverCriteria($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetRetrieverCriteria_withoutAmount_throwsEntityPartialSetException() {

        unset($this->data['amount']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRetrieverCriteria($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetRetrieverCriteria_withInvalidIndex_indexIsThereforeZero_throwsEntityPartialSetException() {

        $this->data['index'] = 'this is not a number.';

        $partialSetRetrieverCriteria = $this->adapter->fromDataToEntityPartialSetRetrieverCriteria($this->data);

        $this->assertEquals($this->container, $partialSetRetrieverCriteria->getContainerName());
        $this->assertEquals(0, $partialSetRetrieverCriteria->getIndex());
        $this->assertEquals($this->amount, $partialSetRetrieverCriteria->getAmount());

    }

    public function testFromDataToEntityPartialSetRetrieverCriteria_withInvalidAmount_amountIsThereforeZero_throwsEntityPartialSetException() {

        $this->data['amount'] = 'this is not a number.';

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetRetrieverCriteria($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
