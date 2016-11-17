<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Services;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\EntitySetService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetServiceHelper {
    private $phpunit;
    private $entityServiceMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntitySetService $entityServiceMock) {
        $this->phpunit = $phpunit;
        $this->entityServiceMock = $entityServiceMock;
    }

    public function expectsInsert_Success(array $entities) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('insert')
                                ->with($entities);
    }

    public function expectsInsert_throwsEntitySetException(array $entities) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('insert')
                                ->with($entities)
                                ->will($this->phpunit->throwException(new EntitySetException('TEST')));
    }

    public function expectsUpdate_Success(array $originalEntities, array $updatedEntities) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('update')
                                ->with($originalEntities, $updatedEntities);
    }

    public function expectsUpdate_throwsEntitySetException(array $originalEntities, array $updatedEntities) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('update')
                                ->with($originalEntities, $updatedEntities)
                                ->will($this->phpunit->throwException(new EntitySetException('TEST')));
    }

    public function expectsDelete_Success(array $entities) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('delete')
                                ->with($entities);
    }

    public function expectsDelete_throwsEntitySetException(array $entities) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('delete')
                                ->with($entities)
                                ->will($this->phpunit->throwException(new EntitySetException('TEST')));
    }

}
