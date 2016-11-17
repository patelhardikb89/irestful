<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname;

final class EntityRetrieverCriteriaHelper {
    private $phpunit;
    private $entityRetrieverCriteriaMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityRetrieverCriteria $entityRetrieverCriteriaMock) {
        $this->phpunit = $phpunit;
        $this->entityRetrieverCriteriaMock = $entityRetrieverCriteriaMock;
    }

    public function expectsGetContainerName_Success($returnedContainerName) {
        $this->entityRetrieverCriteriaMock->expects($this->phpunit->once())
                                            ->method('getContainerName')
                                            ->will($this->phpunit->returnValue($returnedContainerName));
    }

    public function expectsHasUuid_Success($returnedBoolean) {
        $this->entityRetrieverCriteriaMock->expects($this->phpunit->once())
                                            ->method('hasUuid')
                                            ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetUuid_Success(Uuid $returnedUuid) {
        $this->entityRetrieverCriteriaMock->expects($this->phpunit->once())
                                            ->method('getUuid')
                                            ->will($this->phpunit->returnValue($returnedUuid));
    }

    public function expectsHasKeyname_Success($returnedBoolean) {
        $this->entityRetrieverCriteriaMock->expects($this->phpunit->once())
                                            ->method('hasKeyname')
                                            ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetKeyname_Success(Keyname $returnedKeyname) {
        $this->entityRetrieverCriteriaMock->expects($this->phpunit->once())
                                            ->method('getKeyname')
                                            ->will($this->phpunit->returnValue($returnedKeyname));
    }

    public function expectsHasKeynames_Success($returnedBoolean) {
        $this->entityRetrieverCriteriaMock->expects($this->phpunit->once())
                                            ->method('hasKeynames')
                                            ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetKeynames_Success(array $returnedKeynames) {
        $this->entityRetrieverCriteriaMock->expects($this->phpunit->once())
                                            ->method('getKeynames')
                                            ->will($this->phpunit->returnValue($returnedKeynames));
    }

}
