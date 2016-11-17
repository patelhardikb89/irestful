<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet;

final class EntityPartialSetHelper {
    private $phpunit;
    private $entityPartialSetMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityPartialSet $entityPartialSetMock) {
        $this->phpunit = $phpunit;
        $this->entityPartialSetMock = $entityPartialSetMock;
    }

    public function expectsHasEntities_Success($returnedBoolean) {
        $this->entityPartialSetMock->expects($this->phpunit->once())
                                    ->method('hasEntities')
                                    ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetEntities_Success(array $returnedEntities) {
        $this->entityPartialSetMock->expects($this->phpunit->once())
                                    ->method('getEntities')
                                    ->will($this->phpunit->returnValue($returnedEntities));
    }

    public function expectsGetIndex_Success($returnedIndex) {
        $this->entityPartialSetMock->expects($this->phpunit->once())
                                    ->method('getIndex')
                                    ->will($this->phpunit->returnValue($returnedIndex));
    }

    public function expectsGetAmount_Success($returnedAmount) {
        $this->entityPartialSetMock->expects($this->phpunit->once())
                                    ->method('getAmount')
                                    ->will($this->phpunit->returnValue($returnedAmount));
    }

    public function expectsGetTotalAmount_Success($returnedTotalAmount) {
        $this->entityPartialSetMock->expects($this->phpunit->once())
                                    ->method('getTotalAmount')
                                    ->will($this->phpunit->returnValue($returnedTotalAmount));
    }

}
