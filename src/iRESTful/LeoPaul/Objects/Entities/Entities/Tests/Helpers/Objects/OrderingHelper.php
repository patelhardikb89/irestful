<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;

final class OrderingHelper {
    private $phpunit;
    private $orderingMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Ordering $orderingMock) {
        $this->phpunit = $phpunit;
        $this->orderingMock = $orderingMock;
    }

    public function expectsGetNames_Success(array $returnedNames) {
        $this->orderingMock->expects($this->phpunit->once())
                            ->method('getNames')
                            ->will($this->phpunit->returnValue($returnedNames));
    }

    public function expectsIsAscending_Success($returnedBoolean) {
        $this->orderingMock->expects($this->phpunit->once())
                            ->method('isAscending')
                            ->will($this->phpunit->returnValue($returnedBoolean));
    }

}
