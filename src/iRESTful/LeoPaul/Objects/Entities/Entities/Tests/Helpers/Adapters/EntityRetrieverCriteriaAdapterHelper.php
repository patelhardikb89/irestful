<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters\EntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityRetrieverCriteriaAdapterHelper {
    private $phpunit;
    private $entityRetrieverCriteriaAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityRetrieverCriteriaAdapter $entityRetrieverCriteriaAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityRetrieverCriteriaAdapterMock = $entityRetrieverCriteriaAdapterMock;
    }

    public function expectsFromDataToRetrieverCriteria_Success(EntityRetrieverCriteria $returnedCriteria, array $data) {
        $this->entityRetrieverCriteriaAdapterMock->expects($this->phpunit->once())
                                                    ->method('fromDataToRetrieverCriteria')
                                                    ->with($data)
                                                    ->will($this->phpunit->returnValue($returnedCriteria));
    }

    public function expectsFromDataToRetrieverCriteria_throwsEntityException(array $data) {
        $this->entityRetrieverCriteriaAdapterMock->expects($this->phpunit->once())
                                                    ->method('fromDataToRetrieverCriteria')
                                                    ->with($data)
                                                    ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

}
