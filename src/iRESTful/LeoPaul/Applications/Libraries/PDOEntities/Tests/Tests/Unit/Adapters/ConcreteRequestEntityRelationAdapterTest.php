<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestEntityRelationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions\RequestEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityHelper;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Objects\UuidHelper;

final class ConcreteRequestEntityRelationAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityAdapterMock;
    private $entityMock;
    private $uuidMock;
    private $entities;
    private $tableDelimiter;
    private $masterUuid;
    private $originalUuid;
    private $firstSlaveUuid;
    private $secondSlaveUuid;
    private $thirdSlaveUuid;
    private $containerName;
    private $secondContainerName;
    private $relationEntities;
    private $secondRelationEntities;
    private $insertRequests;
    private $deleteRequests;
    private $updateRequests;
    private $adapter;
    private $entityAdapterHelper;
    private $entityHelper;
    private $uuidHelper;
    public function setUp() {

        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

        $this->tableDelimiter = '___';

        $this->entities = [
            $this->entityMock
        ];

        $this->masterUuid = hex2bin(str_replace('-', '', 'f2657db3-05d1-4117-9900-7584befd4694'));
        $this->originalUuid = hex2bin(str_replace('-', '', '34991599-25d3-45ff-ae21-6d0718f77ec2'));
        $this->firstSlaveUuid = hex2bin(str_replace('-', '', '5f3610a9-2eb3-4717-adc3-de8b8023dc3f'));
        $this->secondSlaveUuid = hex2bin(str_replace('-', '', '6a3c0b29-6280-4373-91bc-01441ed62606'));
        $this->thirdSlaveUuid = hex2bin(str_replace('-', '', '072f2aee-9f76-4fa4-9eeb-c99756e87599'));

        $this->containerName = 'my_container';
        $this->secondContainerName = 'second_container';
        $this->relationEntities = [
            'first_keyname' => [
                $this->entityMock,
                $this->entityMock
            ],
            'second_keyname' => [
                $this->entityMock
            ]
        ];

        $this->secondRelationEntities = [

        ];

        $firstTable = $this->containerName.$this->tableDelimiter.'first_keyname';
        $secondTable = $this->containerName.$this->tableDelimiter.'second_keyname';

        $this->deleteRequests = [
            [
                'query' => 'delete from '.$firstTable.' where master_uuid = :uuid;',
                'params' => [
                    ':uuid' => $this->masterUuid
                ]
            ],
            [
                'query' => 'delete from '.$secondTable.' where master_uuid = :uuid;',
                'params' => [
                    ':uuid' => $this->masterUuid
                ]
            ]
        ];

        $this->insertRequests = [
            [
                'query' => 'delete from '.$firstTable.' where master_uuid = :uuid;',
                'params' => [
                    ':uuid' => $this->masterUuid
                ]
            ],
            [
                'query' => 'insert into '.$firstTable.' (master_uuid, slave_uuid) values(:master_uuid, :slave_uuid);',
                'params' => [
                    ':master_uuid' => $this->masterUuid,
                    ':slave_uuid' => $this->firstSlaveUuid
                ]
            ],
            [
                'query' => 'insert into '.$firstTable.' (master_uuid, slave_uuid) values(:master_uuid, :slave_uuid);',
                'params' => [
                    ':master_uuid' => $this->masterUuid,
                    ':slave_uuid' => $this->secondSlaveUuid
                ]
            ],
            [
                'query' => 'delete from '.$secondTable.' where master_uuid = :uuid;',
                'params' => [
                    ':uuid' => $this->masterUuid
                ]
            ],
            [
                'query' => 'insert into '.$secondTable.' (master_uuid, slave_uuid) values(:master_uuid, :slave_uuid);',
                'params' => [
                    ':master_uuid' => $this->masterUuid,
                    ':slave_uuid' => $this->thirdSlaveUuid
                ]
            ]
        ];

        $this->updateRequests = [
            [
                'query' => 'delete from '.$firstTable.' where master_uuid = :uuid;',
                'params' => [
                    ':uuid' => $this->originalUuid
                ]
            ],
            [
                'query' => 'delete from '.$secondTable.' where master_uuid = :uuid;',
                'params' => [
                    ':uuid' => $this->originalUuid
                ]
            ],
            [
                'query' => 'delete from '.$firstTable.' where master_uuid = :uuid;',
                'params' => [
                    ':uuid' => $this->masterUuid
                ]
            ],
            [
                'query' => 'insert into '.$firstTable.' (master_uuid, slave_uuid) values(:master_uuid, :slave_uuid);',
                'params' => [
                    ':master_uuid' => $this->masterUuid,
                    ':slave_uuid' => $this->firstSlaveUuid
                ]
            ],
            [
                'query' => 'insert into '.$firstTable.' (master_uuid, slave_uuid) values(:master_uuid, :slave_uuid);',
                'params' => [
                    ':master_uuid' => $this->masterUuid,
                    ':slave_uuid' => $this->secondSlaveUuid
                ]
            ],
            [
                'query' => 'delete from '.$secondTable.' where master_uuid = :uuid;',
                'params' => [
                    ':uuid' => $this->masterUuid
                ]
            ],
            [
                'query' => 'insert into '.$secondTable.' (master_uuid, slave_uuid) values(:master_uuid, :slave_uuid);',
                'params' => [
                    ':master_uuid' => $this->masterUuid,
                    ':slave_uuid' => $this->thirdSlaveUuid
                ]
            ]
        ];

        $this->adapter = new ConcreteRequestEntityRelationAdapter($this->entityAdapterMock, $this->tableDelimiter);

        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
        $this->entityHelper = new EntityHelper($this, $this->entityMock);
        $this->uuidHelper = new UuidHelper($this, $this->uuidMock);

    }

    public function tearDown() {

    }

    public function testFromEntityToInsertRequests_Success() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock, $this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGet_multiple_Success([$this->masterUuid, $this->firstSlaveUuid, $this->secondSlaveUuid, $this->thirdSlaveUuid]);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntityToRelationEntities_Success($this->relationEntities, $this->entityMock);

        $requests = $this->adapter->fromEntityToInsertRequests($this->entityMock);

        $this->assertEquals($this->insertRequests, $requests);

    }

    public function testFromEntityToInsertRequests_throwsEntityException_throwsRequestEntityException() {

        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->masterUuid);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntityToRelationEntities_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToInsertRequests($this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToInsertRequests_Success() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock, $this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGet_multiple_Success([$this->masterUuid, $this->firstSlaveUuid, $this->secondSlaveUuid, $this->thirdSlaveUuid]);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntityToRelationEntities_Success($this->relationEntities, $this->entityMock);

        $requests = $this->adapter->fromEntitiesToInsertRequests($this->entities);

        $this->assertEquals($this->insertRequests, $requests);

    }

    public function testFromEntityToUpdateRequests_Success() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock, $this->uuidMock, $this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGet_multiple_Success([$this->originalUuid, $this->masterUuid, $this->firstSlaveUuid, $this->secondSlaveUuid, $this->thirdSlaveUuid]);

        $this->entityAdapterMock->expects($this->exactly(2))
                                ->method('fromEntityToContainerName')
                                ->with($this->logicalOr(
                                    $this->equalTo($this->entityMock),
                                    $this->equalTo($this->entityMock)
                                ))
                                ->will($this->onConsecutiveCalls(
                                    $this->containerName,
                                    $this->containerName
                                ));

        $this->entityAdapterMock->expects($this->exactly(2))
                                ->method('fromEntityToRelationEntities')
                                ->with($this->logicalOr(
                                    $this->equalTo($this->entityMock),
                                    $this->equalTo($this->entityMock)
                                ))
                                ->will($this->onConsecutiveCalls(
                                    $this->relationEntities,
                                    $this->relationEntities
                                ));

        $requests = $this->adapter->fromEntityToUpdateRequests($this->entityMock, $this->entityMock);

        $this->assertEquals($this->updateRequests, $requests);
    }

    public function testFromEntityToUpdateRequests_originalUuidSameAsUpdatedUuid_Success() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock, $this->uuidMock, $this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGet_multiple_Success([$this->originalUuid, $this->masterUuid, $this->firstSlaveUuid, $this->secondSlaveUuid, $this->thirdSlaveUuid]);

        $this->entityAdapterMock->expects($this->exactly(2))
                                ->method('fromEntityToContainerName')
                                ->with($this->logicalOr(
                                    $this->equalTo($this->entityMock),
                                    $this->equalTo($this->entityMock)
                                ))
                                ->will($this->onConsecutiveCalls(
                                    $this->containerName,
                                    $this->containerName
                                ));

        $this->entityAdapterMock->expects($this->exactly(2))
                                ->method('fromEntityToRelationEntities')
                                ->with($this->logicalOr(
                                    $this->equalTo($this->entityMock),
                                    $this->equalTo($this->entityMock)
                                ))
                                ->will($this->onConsecutiveCalls(
                                    $this->relationEntities,
                                    $this->relationEntities
                                ));

        $requests = $this->adapter->fromEntityToUpdateRequests($this->entityMock, $this->entityMock);

        $this->assertEquals($this->updateRequests, $requests);
    }

    public function testFromEntityToUpdateRequests_originalUuidSameAsUpdatedUuid_throwsEntityException_throwsRequestEntityException() {

        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->originalUuid);

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntityToRelationEntities_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToUpdateRequests($this->entityMock, $this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromEntitiesToUpdateRequests_Success() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock, $this->uuidMock, $this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGet_multiple_Success([$this->originalUuid, $this->masterUuid, $this->firstSlaveUuid, $this->secondSlaveUuid, $this->thirdSlaveUuid]);

        $this->entityAdapterMock->expects($this->exactly(2))
                                ->method('fromEntityToContainerName')
                                ->with($this->logicalOr(
                                    $this->equalTo($this->entityMock),
                                    $this->equalTo($this->entityMock)
                                ))
                                ->will($this->onConsecutiveCalls(
                                    $this->containerName,
                                    $this->containerName
                                ));

        $this->entityAdapterMock->expects($this->exactly(2))
                                ->method('fromEntityToRelationEntities')
                                ->with($this->logicalOr(
                                    $this->equalTo($this->entityMock),
                                    $this->equalTo($this->entityMock)
                                ))
                                ->will($this->onConsecutiveCalls(
                                    $this->relationEntities,
                                    $this->relationEntities
                                ));

        $requests = $this->adapter->fromEntitiesToUpdateRequests($this->entities, $this->entities);

        $this->assertEquals($this->updateRequests, $requests);

    }

    public function testFromEntitiesToUpdateRequests_throwsEntityException_throwsRequestEntityException() {

        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->originalUuid);

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntityToRelationEntities_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToUpdateRequests($this->entities, $this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToDeleteRequests_Success() {

        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->masterUuid);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntityToRelationEntities_Success($this->relationEntities, $this->entityMock);

        $requests = $this->adapter->fromEntityToDeleteRequests($this->entityMock);

        $this->assertEquals($this->deleteRequests, $requests);

    }

    public function testFromEntityToDeleteRequests_throwsEntityException_throwsRequestEntityException() {

        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->masterUuid);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntityToRelationEntities_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToDeleteRequests($this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToDeleteRequests_Success() {

        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->masterUuid);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntityToRelationEntities_Success($this->relationEntities, $this->entityMock);

        $requests = $this->adapter->fromEntitiesToDeleteRequests($this->entities);

        $this->assertEquals($this->deleteRequests, $requests);

    }

    public function testFromEntitiesToDeleteRequests_throwsEntityException_throwsRequestEntityException() {

        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->masterUuid);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityAdapterHelper->expectsFromEntityToRelationEntities_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToDeleteRequests($this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToParentDeleteRequests_Success() {

        $parentDeleteRequests = $this->adapter->fromEntityToParentDeleteRequests($this->entityMock);

        $this->assertEquals([], $parentDeleteRequests);

    }

    public function testFromEntitiesToParentDeleteRequests_Success() {

        $parentDeleteRequests = $this->adapter->fromEntitiesToParentDeleteRequests($this->entities);

        $this->assertEquals([], $parentDeleteRequests);

    }
}
