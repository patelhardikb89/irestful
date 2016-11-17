<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;

final class EntitySetRetrieverCriteriaHelper {
    private $phpunit;
    private $entitySetRetrieverCriteriaMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntitySetRetrieverCriteria $entitySetRetrieverCriteriaMock) {
        $this->phpunit = $phpunit;
        $this->entitySetRetrieverCriteriaMock = $entitySetRetrieverCriteriaMock;
    }

    public function expectsGetContainerName_Success($returnedContainerName) {
        $this->entitySetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                ->method('getContainerName')
                                                ->will($this->phpunit->returnValue($returnedContainerName));
    }

    public function expectsHasKeyname_Success($returnedBoolean) {
        $this->entitySetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                ->method('hasKeyname')
                                                ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetKeyname_Success(Keyname $returnedKeyname) {
        $this->entitySetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                ->method('getKeyname')
                                                ->will($this->phpunit->returnValue($returnedKeyname));
    }

    public function expectsHasUuids_Success($returnedBoolean) {
        $this->entitySetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                ->method('hasUuids')
                                                ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetUuids_Success(array $returnedUuids) {
        $this->entitySetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                ->method('getUuids')
                                                ->will($this->phpunit->returnValue($returnedUuids));
    }

    public function expectsHasOrdering_Success($returnedBoolean) {
        $this->entitySetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                ->method('hasOrdering')
                                                ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetOrdering_Success(Ordering $returnedOrdering) {
        $this->entitySetRetrieverCriteriaMock->expects($this->phpunit->once())
                                                ->method('getOrdering')
                                                ->will($this->phpunit->returnValue($returnedOrdering));
    }

}
