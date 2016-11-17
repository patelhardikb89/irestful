<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters\EntitySetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetRetrieverCriteriaAdapterHelper {
    private $phpunit;
    private $entitySetRetrieverCriteriaAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntitySetRetrieverCriteriaAdapter $entitySetRetrieverCriteriaAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entitySetRetrieverCriteriaAdapterMock = $entitySetRetrieverCriteriaAdapterMock;
    }

    public function expectsFromDataToEntitySetRetrieverCriteria_Success(EntitySetRetrieverCriteria $returnedCriteria, array $data) {
        $this->entitySetRetrieverCriteriaAdapterMock->expects($this->phpunit->once())
                                                    ->method('fromDataToEntitySetRetrieverCriteria')
                                                    ->with($data)
                                                    ->will($this->phpunit->returnValue($returnedCriteria));
    }

    public function expectsFromDataToEntitySetRetrieverCriteria_throwsEntitySetException(array $data) {
        $this->entitySetRetrieverCriteriaAdapterMock->expects($this->phpunit->once())
                                                    ->method('fromDataToEntitySetRetrieverCriteria')
                                                    ->with($data)
                                                    ->will($this->phpunit->throwException(new EntitySetException('TEST')));
    }

}
