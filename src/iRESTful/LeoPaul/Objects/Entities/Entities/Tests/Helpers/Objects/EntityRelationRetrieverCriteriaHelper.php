<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

final class EntityRelationRetrieverCriteriaHelper {
    private $phpunit;
    private $entityRelationRetrieverCriteriaMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityRelationRetrieverCriteria $entityRelationRetrieverCriteriaMock) {
        $this->phpunit = $phpunit;
        $this->entityRelationRetrieverCriteriaMock = $entityRelationRetrieverCriteriaMock;
    }

    public function expectsGetMasterContainerName_Success($returnedMasterContainerName) {
        $this->entityRelationRetrieverCriteriaMock->expects($this->phpunit->once())
                                                    ->method('getMasterContainerName')
                                                    ->will($this->phpunit->returnValue($returnedMasterContainerName));
    }

    public function expectsGetSlaveContainerName_Success($returnedSlaveContainerName) {
        $this->entityRelationRetrieverCriteriaMock->expects($this->phpunit->once())
                                                    ->method('getSlaveContainerName')
                                                    ->will($this->phpunit->returnValue($returnedSlaveContainerName));
    }

    public function expectsGetSlavePropertyName_Success($returnedSlavePropertyName) {
        $this->entityRelationRetrieverCriteriaMock->expects($this->phpunit->once())
                                                    ->method('getSlavePropertyName')
                                                    ->will($this->phpunit->returnValue($returnedSlavePropertyName));
    }

    public function expectsGetMasterUuid_Success(Uuid $returnedUuid) {
        $this->entityRelationRetrieverCriteriaMock->expects($this->phpunit->once())
                                                    ->method('getMasterUuid')
                                                    ->will($this->phpunit->returnValue($returnedUuid));
    }

}
