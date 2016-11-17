<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Adapters\OrderingAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Exceptions\OrderingException;

final class OrderingAdapterHelper {
    private $phpunit;
    private $orderingAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, OrderingAdapter $orderingAdapterMock) {
        $this->phpunit = $phpunit;
        $this->orderingAdapterMock = $orderingAdapterMock;
    }

    public function expectsFromDataToOrdering_Success(Ordering $returnedOrdering, array $data) {
        $this->orderingAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToOrdering')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedOrdering));
    }

    public function expectsFromDataToOrdering_throwsOrderingException(array $data) {
        $this->orderingAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToOrdering')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new OrderingException('TEST')));
    }

    public function expectsFromOrderingToData_Success(array $returnedData, Ordering $ordering) {
        $this->orderingAdapterMock->expects($this->phpunit->once())
                                    ->method('fromOrderingToData')
                                    ->with($ordering)
                                    ->will($this->phpunit->returnValue($returnedData));
    }

    public function expectsFromOrderingToData_throwsOrderingException(Ordering $ordering) {
        $this->orderingAdapterMock->expects($this->phpunit->once())
                                    ->method('fromOrderingToData')
                                    ->with($ordering)
                                    ->will($this->phpunit->throwException(new OrderingException('TEST')));
    }

}
