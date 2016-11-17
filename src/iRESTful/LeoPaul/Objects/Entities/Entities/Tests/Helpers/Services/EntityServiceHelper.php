<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Services;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityServiceHelper {
    private $phpunit;
    private $entityServiceMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityService $entityServiceMock) {
        $this->phpunit = $phpunit;
        $this->entityServiceMock = $entityServiceMock;
    }

    public function expectsInsert_Success(Entity $entity) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('insert')
                                ->with($entity);
    }

    public function expectsInsert_throwsEntityException(Entity $entity) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('insert')
                                ->with($entity)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsUpdate_Success(Entity $originalEntity, Entity $updatedEntity) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('update')
                                ->with($originalEntity, $updatedEntity);
    }

    public function expectsUpdate_throwsEntityException(Entity $originalEntity, Entity $updatedEntity) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('update')
                                ->with($originalEntity, $updatedEntity)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsDelete_Success(Entity $entity) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('delete')
                                ->with($entity);
    }

    public function expectsDelete_throwsEntityException(Entity $entity) {
        $this->entityServiceMock->expects($this->phpunit->once())
                                ->method('delete')
                                ->with($entity)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

}
