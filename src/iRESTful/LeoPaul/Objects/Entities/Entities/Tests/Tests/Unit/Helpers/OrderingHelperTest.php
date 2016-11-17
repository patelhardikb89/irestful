<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\OrderingHelper;

final class OrderingHelperTest extends \PHPUnit_Framework_TestCase {
    private $orderingMock;
    private $names;
    private $helper;
    public function setUp() {

        $this->orderingMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering');

        $this->names = [
            'created_on',
            'title'
        ];

        $this->helper = new OrderingHelper($this, $this->orderingMock);
    }

    public function tearDown() {

    }

    public function testGetNames_Success() {

        $this->helper->expectsGetNames_Success($this->names);

        $names = $this->orderingMock->getNames();

        $this->assertEquals($this->names, $names);

    }

    public function testIsAscending_Success() {

        $this->helper->expectsIsAscending_Success(false);

        $isAscending = $this->orderingMock->isAscending();

        $this->assertFalse($isAscending);

    }

}
