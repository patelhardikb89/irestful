<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters\EntityPartialSetRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetRetrieverCriteriaAdapterHelper {
    private $phpunit;
    private $entityPartialSetRetrieverCriteriaAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityPartialSetRetrieverCriteriaAdapter $entityPartialSetRetrieverCriteriaAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityPartialSetRetrieverCriteriaAdapterMock = $entityPartialSetRetrieverCriteriaAdapterMock;
    }

    public function expectsFromDataToEntityPartialSetRetrieverCriteria_Success(EntityPartialSetRetrieverCriteria $returnedEntityPartialSetRetrieverCriteria, array $data) {
        $this->entityPartialSetRetrieverCriteriaAdapterMock->expects($this->phpunit->once())
                                                            ->method('fromDataToEntityPartialSetRetrieverCriteria')
                                                            ->with($data)
                                                            ->will($this->phpunit->returnValue($returnedEntityPartialSetRetrieverCriteria));
    }

    public function expectsFromDataToEntityPartialSetRetrieverCriteria_throwsEntityPartialSetException(array $data) {
        $this->entityPartialSetRetrieverCriteriaAdapterMock->expects($this->phpunit->once())
                                                            ->method('fromDataToEntityPartialSetRetrieverCriteria')
                                                            ->with($data)
                                                            ->will($this->phpunit->throwException(new EntityPartialSetException('TEST')));
    }

}
