<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteOrderingAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions\OrderingException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\OrderingHelper;

final class ConcreteOrderingAdapterTest extends \PHPUnit_Framework_TestCase {
    private $orderingMock;
    private $names;
    private $dataWithNames;
    private $dataWithName;
    private $data;
    private $adapter;
    private $orderingHelper;
    public function setUp() {

        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');

        $this->names = [
            'slug',
            'created_on'
        ];

        $this->dataWithNames = [
            'names' => $this->names
        ];

        $this->dataWithName = [
            'name' => 'slug'
        ];

        $this->data = [
            'names' => $this->names,
            'name' => 'uuid',
            'is_ascending' => false
        ];

        $this->adapter = new ConcreteOrderingAdapter();

        $this->orderingHelper = new OrderingHelper($this, $this->orderingMock);
    }

    public function tearDown() {

    }

    public function testFromDataToOrdering_withNames_Success() {

        $ordering = $this->adapter->fromDataToOrdering($this->dataWithNames);

        $this->assertEquals($this->dataWithNames['names'], $ordering->getNames());
        $this->assertTrue($ordering->isAscending());

    }

    public function testFromDataToOrdering_withNames_isAscending_Success() {

        $this->dataWithNames['is_ascending'] = true;
        $ordering = $this->adapter->fromDataToOrdering($this->dataWithNames);

        $this->assertEquals($this->dataWithNames['names'], $ordering->getNames());
        $this->assertTrue($ordering->isAscending());

    }

    public function testFromDataToOrdering_withNames_isDescending_Success() {

        $this->dataWithNames['is_ascending'] = false;
        $ordering = $this->adapter->fromDataToOrdering($this->dataWithNames);

        $this->assertEquals($this->dataWithNames['names'], $ordering->getNames());
        $this->assertFalse($ordering->isAscending());

    }

    public function testFromDataToOrdering_withName_Success() {

        $ordering = $this->adapter->fromDataToOrdering($this->dataWithName);

        $this->assertEquals([$this->dataWithName['name']], $ordering->getNames());
        $this->assertTrue($ordering->isAscending());

    }

    public function testFromDataToOrdering_withName_withNames_Success() {

        $asserted = false;
        try {

            $this->adapter->fromDataToOrdering($this->data);

        } catch (OrderingException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToOrdering_withoutName_withoutNames_Success() {

        $asserted = false;
        try {

            $this->adapter->fromDataToOrdering([]);

        } catch (OrderingException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromOrderingToData_Success() {

        $this->orderingHelper->expectsGetNames_Success($this->names);
        $this->orderingHelper->expectsIsAscending_Success(false);

        $data = $this->adapter->fromOrderingToData($this->orderingMock);

        $this->assertEquals([
            'names' => $this->names,
            'is_ascending' => false
        ], $data);

    }

    public function testFromOrderingToData_isAscending_Success() {

        $this->orderingHelper->expectsGetNames_Success($this->names);
        $this->orderingHelper->expectsIsAscending_Success(true);

        $data = $this->adapter->fromOrderingToData($this->orderingMock);

        $this->assertEquals([
            'names' => $this->names,
            'is_ascending' => true
        ], $data);

    }

}
