<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\OrderingAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions\OrderingException;

final class OrderingAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $orderingAdapterMock;
    private $orderingMock;
    private $data;
    private $helper;
    public function setUp() {
        $this->orderingAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter');
        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');
        $this->data = [
            'names' => ['slug'],
            'is_ascending' => false
        ];

        $this->helper = new OrderingAdapterHelper($this, $this->orderingAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromOrderingToData_Success() {

        $this->helper->expectsFromOrderingToData_Success($this->data, $this->orderingMock);

        $data = $this->orderingAdapterMock->fromOrderingToData($this->orderingMock);

        $this->assertEquals($this->data, $data);

    }

    public function testFromOrderingToData_throwsOrderingException() {

        $this->helper->expectsFromOrderingToData_throwsOrderingException($this->orderingMock);

        $asserted = false;
        try {

            $this->orderingAdapterMock->fromOrderingToData($this->orderingMock);

        } catch (OrderingException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
