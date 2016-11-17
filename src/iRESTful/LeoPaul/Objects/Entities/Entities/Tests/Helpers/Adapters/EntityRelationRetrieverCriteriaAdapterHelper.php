<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters\EntityRelationRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class EntityRelationRetrieverCriteriaAdapterHelper {
    private $phpunit;
    private $entityRelationRetrieverCriteriaAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityRelationRetrieverCriteriaAdapter $entityRelationRetrieverCriteriaAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityRelationRetrieverCriteriaAdapterMock = $entityRelationRetrieverCriteriaAdapterMock;
    }

    public function expectsFromDataToEntityRelationRetrieverCriteria_Success(EntityRelationRetrieverCriteria $returnedEntityRelationRetrieverCriteria, array $data) {
        $this->entityRelationRetrieverCriteriaAdapterMock->expects($this->phpunit->once())
                                                            ->method('fromDataToEntityRelationRetrieverCriteria')
                                                            ->with($data)
                                                            ->will($this->phpunit->returnValue($returnedEntityRelationRetrieverCriteria));
    }

    public function expectsFromDataToEntityRelationRetrieverCriteria_throwsEntityRelationException(array $data) {
        $this->entityRelationRetrieverCriteriaAdapterMock->expects($this->phpunit->once())
                                                            ->method('fromDataToEntityRelationRetrieverCriteria')
                                                            ->with($data)
                                                            ->will($this->phpunit->throwException(new EntityRelationException('TEST')));
    }

}
