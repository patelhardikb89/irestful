<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityAdapterHelper {
    private $phpunit;
    private $entityAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityAdapter $entityAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityAdapterMock = $entityAdapterMock;
    }

    public function expectsFromDataToEntity_Success(Entity $returnedEntity, array $data) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToEntity')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedEntity));
    }

    public function expectsFromDataToEntity_throwsEntityException(array $data) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToEntity')
                                ->with($data)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsFromDataToEntities_Success(array $returnedEntities, array $data) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToEntities')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedEntities));
    }

    public function expectsFromDataToEntities_throwsEntityException(array $data) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToEntities')
                                ->with($data)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsFromEntityToData_Success(array $returnedData, Entity $entity, $isHUmanReadable) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntityToData')
                                ->with($entity, $isHUmanReadable)
                                ->will($this->phpunit->returnValue($returnedData));
    }

    public function expectsFromEntityToData_throwsEntityException(Entity $entity, $isHUmanReadable) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntityToData')
                                ->with($entity, $isHUmanReadable)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsFromEntitiesToData_Success(array $returnedData, array $entities, $isHUmanReadable) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntitiesToData')
                                ->with($entities, $isHUmanReadable)
                                ->will($this->phpunit->returnValue($returnedData));
    }

    public function expectsFromEntitiesToData_throwsEntityException(array $entities, $isHUmanReadable) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntitiesToData')
                                ->with($entities, $isHUmanReadable)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsFromEntityToContainerName_Success($returnedContainerName, Entity $entity) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntityToContainerName')
                                ->with($entity)
                                ->will($this->phpunit->returnValue($returnedContainerName));
    }

    public function expectsFromEntityToContainerName_throwsEntityException(Entity $entity) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntityToContainerName')
                                ->with($entity)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsFromEntitiesToContainerNames_Success(array $returnedContainerNames, array $entities) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntitiesToContainerNames')
                                ->with($entities)
                                ->will($this->phpunit->returnValue($returnedContainerNames));
    }

    public function expectsFromEntitiesToContainerNames_throwsEntityException(array $entities) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntitiesToContainerNames')
                                ->with($entities)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsFromEntityToSubEntities_Success(array $returnedSubEntities, Entity $entity) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntityToSubEntities')
                                ->with($entity)
                                ->will($this->phpunit->returnValue($returnedSubEntities));
    }

    public function expectsFromEntityToSubEntities_throwsEntityException(Entity $entity) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntityToSubEntities')
                                ->with($entity)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsFromEntitiesToSubEntities_Success(array $returnedSubEntities, array $entities) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntitiesToSubEntities')
                                ->with($entities)
                                ->will($this->phpunit->returnValue($returnedSubEntities));
    }

    public function expectsFromEntitiesToSubEntities_throwsEntityException(array $entities) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntitiesToSubEntities')
                                ->with($entities)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsFromEntityToRelationEntities_Success(array $returnedRelationEntities, Entity $entity) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntityToRelationEntities')
                                ->with($entity)
                                ->will($this->phpunit->returnValue($returnedRelationEntities));
    }

    public function expectsFromEntityToRelationEntities_throwsEntityException(Entity $entity) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntityToRelationEntities')
                                ->with($entity)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsFromEntitiesToRelationEntitiesList_Success(array $returnedRelationEntitiesList, array $entities) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntitiesToRelationEntitiesList')
                                ->with($entities)
                                ->will($this->phpunit->returnValue($returnedRelationEntitiesList));
    }

    public function expectsFromEntitiesToRelationEntitiesList_throwsEntityException(array $entities) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntitiesToRelationEntitiesList')
                                ->with($entities)
                                ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsFromEntitiesToUniqueEntities_Success(array $returnedEntities, array $entities) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromEntitiesToUniqueEntities')
                                ->with($entities)
                                ->will($this->phpunit->returnValue($returnedEntities));
    }

    public function expectsFromObjectsToEntities_Success(array $returnedEntities, array $objects) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromObjectsToEntities')
                                ->with($objects)
                                ->will($this->phpunit->returnValue($returnedEntities));
    }

    public function expectsFromRelationObjectsToRelationEntities_Success(array $returnedRelationEntities, array $relationObjects) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromRelationObjectsToRelationEntities')
                                ->with($relationObjects)
                                ->will($this->phpunit->returnValue($returnedRelationEntities));
    }

    public function expectsFromRelationObjectsListToRelationEntitiesList_Success(array $returnedRelationEntitiesList, array $relationObjectsList) {
        $this->entityAdapterMock->expects($this->phpunit->once())
                                ->method('fromRelationObjectsListToRelationEntitiesList')
                                ->with($relationObjectsList)
                                ->will($this->phpunit->returnValue($returnedRelationEntitiesList));
    }

}
