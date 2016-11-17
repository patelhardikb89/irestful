<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityAdapterMock;
    private $entityMock;
    private $data;
    private $multipleData;
    private $entities;
    private $containerName;
    private $containerNames;
    private $relationEntities;
    private $relationEntitiesList;
    private $relationObjects;
    private $relationObjectsList;
    private $helper;
    public function setUp() {
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->data = [
            'some' => 'data'
        ];

        $this->multipleData = [
            $this->data,
            ['other' => 'data']
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->relationEntities = [
            'one_keyname' => $this->entities
        ];

        $this->relationEntitiesList = [
            [],
            $this->relationEntities,
            []
        ];

        $this->relationObjects = [
            'one_keyname' => $this->entities,
            'another_keyname' => [
                new \DateTime()
            ]
        ];

        $this->relationObjectsList = [
            $this->relationObjects,
            $this->relationEntities,
            []
        ];

        $this->containerName = 'my_container';
        $this->containerNames = [
            $this->containerName,
            'another_container'
        ];

        $this->helper = new EntityAdapterHelper($this, $this->entityAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToEntity_Success() {

        $this->helper->expectsFromDataToEntity_Success($this->entityMock, $this->data);

        $entity = $this->entityAdapterMock->fromDataToEntity($this->data);

        $this->assertEquals($this->entityMock, $entity);

    }

    public function testFromDataToEntity_throwsEntityException() {

        $this->helper->expectsFromDataToEntity_throwsEntityException($this->data);

        $asserted = true;
        try {

            $this->entityAdapterMock->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntities_Success() {

        $this->helper->expectsFromDataToEntities_Success($this->entities, $this->multipleData);

        $entities = $this->entityAdapterMock->fromDataToEntities($this->multipleData);

        $this->assertEquals($this->entities, $entities);
    }

    public function testFromDataToEntities_throwsEntityException() {

        $this->helper->expectsFromDataToEntities_throwsEntityException($this->multipleData);

        $asserted = true;
        try {

            $this->entityAdapterMock->fromDataToEntities($this->multipleData);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromEntityToData_Success() {

        $this->helper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);

        $data = $this->entityAdapterMock->fromEntityToData($this->entityMock, true);

        $this->assertEquals($this->data, $data);

    }

    public function testFromEntityToData_throwsEntityException() {

        $this->helper->expectsFromEntityToData_throwsEntityException($this->entityMock, true);

        $asserted = true;
        try {

            $this->entityAdapterMock->fromEntityToData($this->entityMock, true);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToData_Success() {

        $this->helper->expectsFromEntitiesToData_Success($this->multipleData, $this->entities, false);

        $data = $this->entityAdapterMock->fromEntitiesToData($this->entities, false);

        $this->assertEquals($this->multipleData, $data);

    }

    public function testFromEntitiesToData_throwsEntityException() {

        $this->helper->expectsFromEntitiesToData_throwsEntityException($this->entities, false);

        $asserted = true;
        try {

            $this->entityAdapterMock->fromEntitiesToData($this->entities, false);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToContainerName_Success() {

        $this->helper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);

        $containerName = $this->entityAdapterMock->fromEntityToContainerName($this->entityMock);

        $this->assertEquals($this->containerName, $containerName);

    }

    public function testFromEntityToContainerName_throwsEntityException() {

        $this->helper->expectsFromEntityToContainerName_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->entityAdapterMock->fromEntityToContainerName($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToContainerNames_Success() {

        $this->helper->expectsFromEntitiesToContainerNames_Success($this->containerNames, $this->entities);

        $containerNames = $this->entityAdapterMock->fromEntitiesToContainerNames($this->entities);

        $this->assertEquals($this->containerNames, $containerNames);

    }

    public function testFromEntitiesToContainerNames_throwsEntityException() {

        $this->helper->expectsFromEntitiesToContainerNames_throwsEntityException($this->entities);

        $asserted = false;
        try {

            $this->entityAdapterMock->fromEntitiesToContainerNames($this->entities);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToSubEntities_Success() {

        $this->helper->expectsFromEntityToSubEntities_Success($this->entities, $this->entityMock);

        $entities = $this->entityAdapterMock->fromEntityToSubEntities($this->entityMock);

        $this->assertEquals($this->entities, $entities);

    }

    public function testFromEntityToSubEntities_throwsEntityException() {

        $this->helper->expectsFromEntityToSubEntities_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->entityAdapterMock->fromEntityToSubEntities($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToSubEntities_Success() {

        $this->helper->expectsFromEntitiesToSubEntities_Success([$this->entityMock], $this->entities);

        $entities = $this->entityAdapterMock->fromEntitiesToSubEntities($this->entities);

        $this->assertEquals([$this->entityMock], $entities);

    }

    public function testFromEntitiesToSubEntities_throwsEntityException() {

        $this->helper->expectsFromEntitiesToSubEntities_throwsEntityException($this->entities);

        $asserted = false;
        try {

            $this->entityAdapterMock->fromEntitiesToSubEntities($this->entities);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToRelationEntities_Success() {

        $this->helper->expectsFromEntityToRelationEntities_Success($this->relationEntities, $this->entityMock);

        $relationEntities = $this->entityAdapterMock->fromEntityToRelationEntities($this->entityMock);

        $this->assertEquals($this->relationEntities, $relationEntities);

    }

    public function testFromEntityToRelationEntities_throwsEntityException() {

        $this->helper->expectsFromEntityToRelationEntities_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->entityAdapterMock->fromEntityToRelationEntities($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToRelationEntitiesList_Success() {

        $this->helper->expectsFromEntitiesToRelationEntitiesList_Success($this->relationEntitiesList, $this->entities);

        $relationEntitiesList = $this->entityAdapterMock->fromEntitiesToRelationEntitiesList($this->entities);

        $this->assertEquals($this->relationEntitiesList, $relationEntitiesList);

    }

    public function testFromEntitiesToRelationEntitiesList_throwsEntityException() {

        $this->helper->expectsFromEntitiesToRelationEntitiesList_throwsEntityException($this->entities);

        $asserted = false;
        try {

            $this->entityAdapterMock->fromEntitiesToRelationEntitiesList($this->entities);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToUniqueEntities_Success() {

        $this->helper->expectsFromEntitiesToUniqueEntities_Success([$this->entityMock], $this->entities);

        $entities = $this->entityAdapterMock->fromEntitiesToUniqueEntities($this->entities);

        $this->assertEquals([$this->entityMock], $entities);

    }

    public function testFromObjectsToEntities_Success() {

        $this->helper->expectsFromObjectsToEntities_Success([$this->entityMock], $this->entities);

        $entities = $this->entityAdapterMock->fromObjectsToEntities($this->entities);

        $this->assertEquals([$this->entityMock], $entities);

    }

    public function testFromRelationObjectsToRelationEntities_Success() {

        $this->helper->expectsFromRelationObjectsToRelationEntities_Success($this->relationEntities, $this->relationObjects);

        $relationEntities = $this->entityAdapterMock->fromRelationObjectsToRelationEntities($this->relationObjects);

        $this->assertEquals($this->relationEntities, $relationEntities);

    }

    public function testFromRelationObjectsListToRelationEntitiesList_Success() {

        $this->helper->expectsFromRelationObjectsListToRelationEntitiesList_Success($this->relationEntitiesList, $this->relationObjectsList);

        $relationEntitiesList = $this->entityAdapterMock->fromRelationObjectsListToRelationEntitiesList($this->relationObjectsList);

        $this->assertEquals($this->relationEntitiesList, $relationEntitiesList);

    }

}
