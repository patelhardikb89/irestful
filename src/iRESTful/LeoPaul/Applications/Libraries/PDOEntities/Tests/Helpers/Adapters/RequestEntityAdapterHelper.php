<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions\RequestEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

final class RequestEntityAdapterHelper {
    private $phpunit;
    private $requestEntityAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RequestEntityAdapter $requestEntityAdapterMock) {
        $this->phpunit = $phpunit;
        $this->requestEntityAdapterMock = $requestEntityAdapterMock;
    }

    public function expectsFromEntityToInsertRequests_Success(array $returnedRequests, Entity $entity) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntityToInsertRequests')
                                        ->with($entity)
                                        ->will($this->phpunit->returnValue($returnedRequests));
    }

    public function expectsFromEntityToInsertRequests_throwsRequestEntityException(Entity $entity) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntityToInsertRequests')
                                        ->with($entity)
                                        ->will($this->phpunit->throwException(new RequestEntityException('TEST')));
    }

    public function expectsFromEntitiesToInsertRequests_Success(array $returnedRequests, array $entities) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntitiesToInsertRequests')
                                        ->with($entities)
                                        ->will($this->phpunit->returnValue($returnedRequests));
    }

    public function expectsFromEntitiesToInsertRequests_throwsRequestEntityException(array $entities) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntitiesToInsertRequests')
                                        ->with($entities)
                                        ->will($this->phpunit->throwException(new RequestEntityException('TEST')));
    }

    public function expectsFromEntityToUpdateRequests_Success(array $returnedRequests, Entity $originalEntity, Entity $updatedEntity) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntityToUpdateRequests')
                                        ->with($originalEntity, $updatedEntity)
                                        ->will($this->phpunit->returnValue($returnedRequests));
    }

    public function expectsFromEntityToUpdateRequests_throwsRequestEntityException(Entity $originalEntity, Entity $updatedEntity) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntityToUpdateRequests')
                                        ->with($originalEntity, $updatedEntity)
                                        ->will($this->phpunit->throwException(new RequestEntityException('TEST')));
    }

    public function expectsFromEntitiesToUpdateRequests_Success(array $returnedRequests, array $originalEntities, array $updatedEntities) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntitiesToUpdateRequests')
                                        ->with($originalEntities, $updatedEntities)
                                        ->will($this->phpunit->returnValue($returnedRequests));
    }

    public function expectsFromEntitiesToUpdateRequests_throwsRequestEntityException(array $originalEntities, array $updatedEntities) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntitiesToUpdateRequests')
                                        ->with($originalEntities, $updatedEntities)
                                        ->will($this->phpunit->throwException(new RequestEntityException('TEST')));
    }

    public function expectsFromEntityToDeleteRequests_Success(array $returnedRequests, Entity $entity) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntityToDeleteRequests')
                                        ->with($entity)
                                        ->will($this->phpunit->returnValue($returnedRequests));
    }

    public function expectsFromEntityToDeleteRequests_throwsRequestEntityException(Entity $entity) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntityToDeleteRequests')
                                        ->with($entity)
                                        ->will($this->phpunit->throwException(new RequestEntityException('TEST')));
    }

    public function expectsFromEntitiesToDeleteRequests_Success(array $returnedRequests, array $entities) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntitiesToDeleteRequests')
                                        ->with($entities)
                                        ->will($this->phpunit->returnValue($returnedRequests));
    }

    public function expectsFromEntitiesToDeleteRequests_throwsRequestEntityException(array $entities) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntitiesToDeleteRequests')
                                        ->with($entities)
                                        ->will($this->phpunit->throwException(new RequestEntityException('TEST')));
    }

    public function expectsFromEntityToParentDeleteRequests_Success(array $returnedRequests, Entity $entity) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntityToParentDeleteRequests')
                                        ->with($entity)
                                        ->will($this->phpunit->returnValue($returnedRequests));
    }

    public function expectsFromEntitiesToParentDeleteRequests_Success(array $returnedRequests, array $entities) {
        $this->requestEntityAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntitiesToParentDeleteRequests')
                                        ->with($entities)
                                        ->will($this->phpunit->returnValue($returnedRequests));
    }

}
