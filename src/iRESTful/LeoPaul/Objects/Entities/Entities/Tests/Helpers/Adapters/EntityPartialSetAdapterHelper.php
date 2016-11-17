<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetAdapterHelper {
    private $phpunit;
    private $entityPartialSetAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityPartialSetAdapter $entityPartialSetAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityPartialSetAdapterMock = $entityPartialSetAdapterMock;
    }

    public function expectsFromDataToEntityPartialSet_Success(EntityPartialSet $returnedEntityPartialSet, array $data) {
        $this->entityPartialSetAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityPartialSet')
                                            ->with($data)
                                            ->will($this->phpunit->returnValue($returnedEntityPartialSet));
    }

    public function expectsFromDataToEntityPartialSet_throwsEntityPartialSetException(array $data) {
        $this->entityPartialSetAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityPartialSet')
                                            ->with($data)
                                            ->will($this->phpunit->throwException(new EntityPartialSetException('TEST')));
    }

    public function expectsFromEntityPartialSetToData_Success(array $returnedData, EntityPartialSet $entityPartialSet) {
        $this->entityPartialSetAdapterMock->expects($this->phpunit->once())
                                            ->method('fromEntityPartialSetToData')
                                            ->with($entityPartialSet)
                                            ->will($this->phpunit->returnValue($returnedData));
    }

    public function expectsFromEntityPartialSetToData_throwsEntityPartialSetException(EntityPartialSet $entityPartialSet) {
        $this->entityPartialSetAdapterMock->expects($this->phpunit->once())
                                            ->method('fromEntityPartialSetToData')
                                            ->with($entityPartialSet)
                                            ->will($this->phpunit->throwException(new EntityPartialSetException('TEST')));
    }

}
