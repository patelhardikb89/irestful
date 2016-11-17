<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\ConcreteObjectAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\ClassMetaDataHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityRepositoryHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Repositories\ClassMetaDataRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityRelationRepositoryHelper;

final class ConcreteEntityAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRepositoryMock;
    private $entityRepositoryMock;
    private $simpleEntityMock;
    private $objectAdapterFactoryMock;
    private $classMetaDataRepositoryMock;
    private $classMetaDataMock;
    private $objectAdapter;
    private $objectAdapterWithNonEntityClass;
    private $objectAdapterThrowsException;
    private $objectAdapterExecutesInvalidCallback;
    private $className;
    private $containerName;
    private $subEntityUuid;
    private $slaveProperty;
    private $data;
    private $multipleData;
    private $subObjects;
    private $relationObjects;
    private $relationObjectsList;
    private $subEntities;
    private $relationEntities;
    private $relationEntitiesList;
    private $adapter;
    private $adapterWithNonEntityClassInObjectAdapter;
    private $adapterThrowsObjectException;
    private $adapterExecutesInvalidCallback;
    private $entityRelationRepositoryHelper;
    private $entityRepositoryHelper;
    private $classMetaDataRepositoryHelper;
    private $classMetaDataHelper;
    public function setUp() {
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->simpleEntityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\SimpleEntity');
        $this->classMetaDataRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository');
        $this->classMetaDataMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData');

        $this->className = 'iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\ConcreteSimpleEntity';
        $this->containerName = 'simple_entity';
        $this->subEntityUuid = '113d3695-fe52-49bb-a32b-cc1d0369de26';
        $this->slaveProperty = 'my_property';

        $keynameClasses = [
            'sub_entities' => $this->className
        ];

        $keynameClassesWithNonEntityClass = [
            'sub_entities' => '\DateTime'
        ];

        $keynameRelationData = [
            'another_sub_entities' => [
                'master_container' => $this->containerName,
                'slave_type' => $this->className,
                'slave_property' => 'my_property'
            ]
        ];

        $this->data = [
            'container' => $this->containerName,
            'data' => [
                'uuid' => 'a69c074e-261a-4f16-82f1-3c8e75aa6a61',
                'created_on' => time(),
                'title' => 'This is a title',
                'description' => 'This is a description',
                'slug' => 'this-is-a-slug',
                'sub_entities' => [
                    $this->subEntityUuid
                ],
                'another_sub_entities' => null
            ]
        ];

        $this->multipleData = [
            $this->data
        ];

        $this->subObjects = [
            $this->simpleEntityMock,
            $this->simpleEntityMock,
            $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid'),
            $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid')
        ];

        $this->relationObjects = [
            'first_keyname' => $this->subObjects
        ];

        $this->relationObjectsList = [
            [],
            $this->relationObjects
        ];

        $this->subEntities = [
            $this->simpleEntityMock
        ];

        $this->relationEntities = [
            'first_keyname' => $this->subEntities
        ];

        $this->relationEntitiesList = [
            [],
            $this->relationEntities
        ];

        $this->objectAdapter = new ConcreteObjectAdapter($keynameClasses, $keynameRelationData, $this->data , $this->simpleEntityMock, $this->subObjects, $this->relationObjects, $this->relationObjectsList, false, false);
        $this->objectAdapterWithNonEntityClass = new ConcreteObjectAdapter($keynameClassesWithNonEntityClass, $keynameRelationData, $this->data , $this->simpleEntityMock, [], [], [[]], false, false);
        $this->objectAdapterThrowsException = new ConcreteObjectAdapter($keynameClasses, $keynameRelationData, $this->data , $this->simpleEntityMock, $this->subObjects, $this->relationObjects, $this->relationObjectsList, true, false);
        $this->objectAdapterExecutesInvalidCallback = new ConcreteObjectAdapter($keynameClasses, $keynameRelationData, $this->data , $this->simpleEntityMock, $this->subObjects, $this->relationObjects, $this->relationObjectsList, false, true);

        $this->adapter = new ConcreteEntityAdapter($this->entityRepositoryMock , $this->entityRelationRepositoryMock, $this->objectAdapter , $this->classMetaDataRepositoryMock);
        $this->adapterWithNonEntityClassInObjectAdapter = new ConcreteEntityAdapter($this->entityRepositoryMock , $this->entityRelationRepositoryMock, $this->objectAdapterWithNonEntityClass , $this->classMetaDataRepositoryMock);
        $this->adapterThrowsObjectException = new ConcreteEntityAdapter($this->entityRepositoryMock , $this->entityRelationRepositoryMock, $this->objectAdapterThrowsException , $this->classMetaDataRepositoryMock);
        $this->adapterExecutesInvalidCallback = new ConcreteEntityAdapter($this->entityRepositoryMock , $this->entityRelationRepositoryMock, $this->objectAdapterExecutesInvalidCallback , $this->classMetaDataRepositoryMock);

        $this->entityRelationRepositoryHelper = new EntityRelationRepositoryHelper($this, $this->entityRelationRepositoryMock);
        $this->classMetaDataRepositoryHelper = new ClassMetaDataRepositoryHelper($this, $this->classMetaDataRepositoryMock);
        $this->classMetaDataHelper = new ClassMetaDataHelper($this, $this->classMetaDataMock);
        $this->entityRepositoryHelper = new EntityRepositoryHelper($this, $this->entityRepositoryMock);

    }

    public function tearDown() {

    }

    public function testFromEntityToSubEntities_Success() {

        $subEntities = $this->adapter->fromEntityToSubEntities($this->simpleEntityMock);

        $this->assertEquals($this->subEntities, $subEntities);

    }

    public function testFromEntityToSubEntities_throwsObjectException_throwsEntityException() {

        $asserted = false;
        try {

            $this->adapterThrowsObjectException->fromEntityToSubEntities($this->simpleEntityMock);

        } catch (EntityException $Exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToSubEntities_Success() {

        $subEntities = $this->adapter->fromEntitiesToSubEntities([$this->simpleEntityMock, $this->simpleEntityMock]);

        $this->assertEquals($this->subEntities, $subEntities);

    }

    public function testFromEntitiesToSubEntities_throwsObjectException_throwsEntityException() {

        $asserted = false;
        try {

            $this->adapterThrowsObjectException->fromEntitiesToSubEntities([$this->simpleEntityMock, $this->simpleEntityMock]);

        } catch (EntityException $Exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntity_Success() {

        $this->classMetaDataRepositoryMock->expects($this->exactly(2))
                                            ->method('retrieve')
                                            ->with($this->logicalOr(
                                                $this->equalTo(['class' => $this->className]),
                                                $this->equalTo(['class' => $this->className])
                                            ))
                                            ->will($this->onConsecutiveCalls(
                                                $this->classMetaDataMock,
                                                $this->classMetaDataMock
                                            ));

        $this->classMetaDataMock->expects($this->exactly(2))
                                ->method('hasContainerName')
                                ->will($this->onConsecutiveCalls(true, true));

        $this->classMetaDataMock->expects($this->exactly(2))
                                ->method('getContainerName')
                                ->will($this->onConsecutiveCalls($this->containerName, $this->containerName));

        $this->entityRepositoryHelper->expectsRetrieve_Success($this->simpleEntityMock, [
            'container' => $this->containerName,
            'uuid' => $this->subEntityUuid
        ]);

        $this->entityRelationRepositoryHelper->expectsRetrieve_Success([$this->simpleEntityMock, $this->simpleEntityMock], [
            'master_container' => $this->containerName,
            'slave_container' => $this->containerName,
            'slave_property' => $this->slaveProperty,
            'master_uuid' => $this->data['data']['uuid']
        ]);

        $simpleEntity = $this->adapter->fromDataToEntity($this->data);

        $this->assertEquals($this->simpleEntityMock , $simpleEntity);

    }

    public function testFromDataToEntity_throwsEntityRelationException_throwsEntityException() {

        $this->classMetaDataRepositoryMock->expects($this->exactly(2))
                                            ->method('retrieve')
                                            ->with($this->logicalOr(
                                                $this->equalTo(['class' => $this->className]),
                                                $this->equalTo(['class' => $this->className])
                                            ))
                                            ->will($this->onConsecutiveCalls(
                                                $this->classMetaDataMock,
                                                $this->classMetaDataMock
                                            ));

        $this->classMetaDataMock->expects($this->exactly(2))
                                ->method('hasContainerName')
                                ->will($this->onConsecutiveCalls(true, true));

        $this->classMetaDataMock->expects($this->exactly(2))
                                ->method('getContainerName')
                                ->will($this->onConsecutiveCalls($this->containerName, $this->containerName));

        $this->entityRepositoryHelper->expectsRetrieve_Success($this->simpleEntityMock, [
            'container' => $this->containerName,
            'uuid' => $this->subEntityUuid
        ]);

        $this->entityRelationRepositoryHelper->expectsRetrieve_throwsEntityRelationException([
            'master_container' => $this->containerName,
            'slave_container' => $this->containerName,
            'slave_property' => $this->slaveProperty,
            'master_uuid' => $this->data['data']['uuid']
        ]);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntity_withoutContainerName_whileRetrievingRelatedEntities_throwsEntityException() {

        $this->classMetaDataRepositoryMock->expects($this->exactly(2))
                                            ->method('retrieve')
                                            ->with($this->logicalOr(
                                                $this->equalTo(['class' => $this->className]),
                                                $this->equalTo(['class' => $this->className])
                                            ))
                                            ->will($this->onConsecutiveCalls(
                                                $this->classMetaDataMock,
                                                $this->classMetaDataMock
                                            ));

        $this->classMetaDataMock->expects($this->exactly(2))
                                ->method('hasContainerName')
                                ->will($this->onConsecutiveCalls(true, false));

        $this->classMetaDataHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->simpleEntityMock, [
            'container' => $this->containerName,
            'uuid' => $this->subEntityUuid
        ]);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntity_throwsEntityException() {

        $this->classMetaDataRepositoryHelper->expectsRetrieve_Success($this->classMetaDataMock, ['class' => $this->className]);
        $this->classMetaDataHelper->expectsHasContainerName_Success(true);
        $this->classMetaDataHelper->expectsGetContainerName_Success($this->containerName);
        $this->entityRepositoryHelper->expectsRetrieve_throwsEntityException([
            'container' => $this->containerName,
            'uuid' => $this->subEntityUuid
        ]);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntity_withoutContainerName_throwsEntityException() {

        $this->classMetaDataRepositoryHelper->expectsRetrieve_Success($this->classMetaDataMock, ['class' => $this->className]);
        $this->classMetaDataHelper->expectsHasContainerName_Success(false);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntity_throwsClassMetaDataException_throwsEntityException() {

        $this->classMetaDataRepositoryHelper->expectsRetrieve_throwsClassMetaDataException(['class' => $this->className]);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntity_classNameIsNotAnEntity_throwsEntityException() {

        $asserted = false;
        try {

            $this->adapterWithNonEntityClassInObjectAdapter->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntity_withEmptyInput_throwsEntityException() {

        $asserted = false;
        try {

            $this->data['data']['sub_entities'][0] = '';
            $this->adapter->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntity_withNonStringInput_throwsEntityException() {

        $asserted = false;
        try {

            $this->data['data']['sub_entities'][0] = new \DateTime();
            $this->adapter->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntity_executesInvalidCallback_throwsEntityException() {

        $asserted = false;
        try {

            $this->adapterExecutesInvalidCallback->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntity_throwsObjectException_throwsEntityException() {

        $asserted = false;
        try {

            $this->adapterThrowsObjectException->fromDataToEntity($this->data);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntities_Success() {

        $entities = $this->adapter->fromDataToEntities([$this->multipleData]);

        $this->assertEquals([$this->simpleEntityMock], $entities);

    }

    public function testFromDataToEntities_throwsObjectException_throwsEntityException() {

        $asserted = false;
        try {

            $this->adapterThrowsObjectException->fromDataToEntities([$this->multipleData]);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToData_Success() {

        $data = $this->adapter->fromEntityToData($this->simpleEntityMock, true);

        $this->assertEquals($this->data, $data);

    }

    public function testFromEntityToData_throwsObjectException_throwsEntityException() {

        $asserted = false;
        try {

            $this->adapterThrowsObjectException->fromEntityToData($this->simpleEntityMock, true);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToData_Success() {

        $data = $this->adapter->fromEntitiesToData([$this->simpleEntityMock], false);

        $this->assertEquals($this->multipleData, $data);

    }

    public function testFromEntitiesToData_throwsObjectException_throwsEntityException() {

        $asserted = false;
        try {

            $this->adapterThrowsObjectException->fromEntitiesToData([$this->simpleEntityMock], false);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToContainerName_Success() {

        $this->classMetaDataRepositoryHelper->expectsRetrieve_Success($this->classMetaDataMock, ['object' => $this->simpleEntityMock]);
        $this->classMetaDataHelper->expectsHasContainerName_Success(true);
        $this->classMetaDataHelper->expectsGetContainerName_Success($this->containerName);

        $containerName = $this->adapter->fromEntityToContainerName($this->simpleEntityMock);

        $this->assertEquals($this->containerName, $containerName);
    }

    public function testFromEntityToContainerName_withoutContainerName_throwsEntityException() {

        $this->classMetaDataRepositoryHelper->expectsRetrieve_Success($this->classMetaDataMock, ['object' => $this->simpleEntityMock]);
        $this->classMetaDataHelper->expectsHasContainerName_Success(false);

        $asserted = false;
        try {

            $this->adapter->fromEntityToContainerName($this->simpleEntityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromEntityToContainerName_throwsClassMetaDataException_throwsEntityException() {

        $this->classMetaDataRepositoryHelper->expectsRetrieve_throwsClassMetaDataException(['object' => $this->simpleEntityMock]);

        $asserted = false;
        try {

            $this->adapter->fromEntityToContainerName($this->simpleEntityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromEntitiesToContainerNames_Success() {

        $this->classMetaDataRepositoryHelper->expectsRetrieve_Success($this->classMetaDataMock, ['object' => $this->simpleEntityMock]);
        $this->classMetaDataHelper->expectsHasContainerName_Success(true);
        $this->classMetaDataHelper->expectsGetContainerName_Success($this->containerName);

        $containerNames = $this->adapter->fromEntitiesToContainerNames([$this->simpleEntityMock]);

        $this->assertEquals([$this->containerName], $containerNames);

    }

    public function testFromEntitiesToContainerNames_withoutContainerName_throwsEntityException() {

        $this->classMetaDataRepositoryHelper->expectsRetrieve_Success($this->classMetaDataMock, ['object' => $this->simpleEntityMock]);
        $this->classMetaDataHelper->expectsHasContainerName_Success(false);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToContainerNames([$this->simpleEntityMock]);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromRelationObjectsToRelationEntities_Success() {

        $relationEntities = $this->adapter->fromRelationObjectsToRelationEntities($this->relationObjects);

        $this->assertEquals($this->relationEntities, $relationEntities);

    }

    public function testFromRelationObjectsListToRelationEntitiesList_Success() {

        $relationEntitiesList = $this->adapter->fromRelationObjectsListToRelationEntitiesList($this->relationObjectsList);

        $this->assertEquals($this->relationEntitiesList, $relationEntitiesList);

    }

    public function testFromEntityToRelationEntities_Success() {

        $relationEntities = $this->adapter->fromEntityToRelationEntities($this->simpleEntityMock);

        $this->assertEquals($this->relationEntities, $relationEntities);

    }

    public function testFromEntityToRelationEntities_withNonEntityClass_Success() {

        $relationEntities = $this->adapterWithNonEntityClassInObjectAdapter->fromEntityToRelationEntities($this->simpleEntityMock);

        $this->assertEquals([], $relationEntities);
    }

    public function testFromEntityToRelationEntities_throwsObjectException_throwsEntityException() {

        $asserted = false;
        try {

            $this->adapterThrowsObjectException->fromEntityToRelationEntities($this->simpleEntityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromEntitiesToRelationEntitiesList_Success() {

        $relationEntities = $this->adapter->fromEntitiesToRelationEntitiesList([$this->simpleEntityMock, $this->simpleEntityMock]);

        $this->assertEquals($this->relationEntitiesList, $relationEntities);

    }

    public function testFromEntitiesToRelationEntitiesList_withNonEntityClass_Success() {

        $relationEntities = $this->adapterWithNonEntityClassInObjectAdapter->fromEntitiesToRelationEntitiesList([$this->simpleEntityMock, $this->simpleEntityMock]);

        $this->assertEquals([[]], $relationEntities);

    }

    public function testFromEntitiesToRelationEntitiesList_throwsObjectException_throwsEntityException() {

        $asserted = false;
        try {

            $this->adapterThrowsObjectException->fromEntitiesToRelationEntitiesList([$this->simpleEntityMock, $this->simpleEntityMock]);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }


}
