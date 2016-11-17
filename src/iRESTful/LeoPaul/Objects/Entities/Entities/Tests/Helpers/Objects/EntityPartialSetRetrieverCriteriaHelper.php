<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;

final class EntityPartialSetRetrieverCriteriaHelper {
    private $phpunit;
    private $entityPartialSetRetrieverCriteriaMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityPartialSetRetrieverCriteria $entityPartialSetRetrieverCriteriaMock) {
        $this->phpunit = $phpunit;
        $this->entityPartialSetRetrieverCriteriaMock = $entityPartialSetRetrieverCriteriaMock;
    }

    public function expectsGetContainerName_Success($returnedContainerName) {
        $this->entityPartialSetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                        ->method('getContainerName')
                                                        ->will($this->phpunit->returnValue($returnedContainerName));
    }

    public function expectsGetIndex_Success($returnedIndex) {
        $this->entityPartialSetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                        ->method('getIndex')
                                                        ->will($this->phpunit->returnValue($returnedIndex));
    }

    public function expectsGetAmount_Success($returnedAmount) {
        $this->entityPartialSetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                        ->method('getAmount')
                                                        ->will($this->phpunit->returnValue($returnedAmount));
    }

    public function expectsHasOrdering_Success($returnedBoolean) {
        $this->entityPartialSetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                        ->method('hasOrdering')
                                                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetOrdering_Success(Ordering $returnedOrdering) {
        $this->entityPartialSetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                        ->method('getOrdering')
                                                        ->will($this->phpunit->returnValue($returnedOrdering));
    }

}
