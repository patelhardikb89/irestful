<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcreteRequestEntityAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Objects\UuidHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\RequestEntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Exceptions\RequestEntityException;

final class ConcreteRequestEntityAdapterTest extends \PHPUnit_Framework_TestCase {
    private $requestEntityAdapterMock;
    private $entityAdapterMock;
    private $simpleEntityMock;
    private $entityMock;
    private $uuidMock;
    private $entities;
    private $containerName;
    private $humanReadableUuid;
    private $uuid;
    private $data;
    private $originalData;
    private $insertData;
    private $updateData;
    private $deleteData;
    private $insertRequest;
    private $updateRequest;
    private $deleteRequest;
    private $deleteRequests;
    private $subRequests;
    private $adapter;
    private $requestEntityAdapterHelper;
    private $entityAdapterHelper;
    private $entityHelper;
    private $uuidHelper;
    public function setUp() {

        $this->requestEntityAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->simpleEntityMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Objects\SimpleEntity');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->entities = [
            $this->entityMock
        ];
        $this->containerName = 'my_container';

        $this->humanReadableUuid = '2819b42f-efd3-4a9a-a73f-4705bbf3ac1b';
        $this->uuid = hex2bin(str_replace('-', '', $this->humanReadableUuid));
        $subUuid = hex2bin(str_replace('-', '', 'f33a0ab8-5829-4f47-89ba-3a224fe4857c'));

        $this->data = [
            'uuid' => $this->uuid,
            'created_on' => time(),
            'title' => 'Just a title',
            'sub_subject' => [
                'uuid' => $subUuid,
                'title' => 'My Sub Object',
                'description' => 'Another description'
            ],
            'sub_objects' => [
                [
                    'uuid' => $subUuid,
                    'title' => 'My Sub Object',
                    'description' => 'Another description'
                ]
            ],
            'null_property' => null,
            'can_be_null' => null
        ];

        $this->originalData = [
            'uuid' => $this->uuid,
            'created_on' => time(),
            'title' => 'Just a title',
            'sub_subject' => [
                'uuid' => $subUuid,
                'title' => 'My Sub Object',
                'description' => 'Another description'
            ],
            'sub_objects' => [
                [
                    'uuid' => $subUuid,
                    'title' => 'My Sub Object',
                    'description' => 'Another description'
                ]
            ],
            'null_property' => null,
            'can_be_null' => 'this has a value'
        ];

        $this->insertData = [
            'uuid' => $this->uuid,
            'created_on' => time(),
            'title' => 'Just a title',
            'sub_subject' => $subUuid
        ];

        $this->updateData = [
            'uuid' => $this->uuid,
            '__original_uuid__' => $this->uuid,
            'created_on' => time(),
            'title' => 'Just a title',
            'sub_subject' => $subUuid,
            'can_be_null' => null
        ];

        $this->deleteData = [
            'uuid' => $this->uuid
        ];

        $this->subRequests = [
            [
                'query' => 'lets say this is a sub query'
            ]
        ];

        $this->insertRequest = [
            'query' => 'insert into '.$this->containerName.' (uuid, created_on, title, sub_subject) values(:uuid, :created_on, :title, :sub_subject);',
            'params' => $this->insertData
        ];

        $this->updateRequest = [
            'query' => 'update '.$this->containerName.' set uuid = :uuid, created_on = :created_on, title = :title, sub_subject = :sub_subject, can_be_null = :can_be_null where uuid = :__original_uuid__;',
            'params' => $this->updateData
        ];

        $this->deleteRequest = [
            'query' => 'delete from '.$this->containerName.' where uuid = :uuid;',
            'params' => $this->deleteData
        ];

        $this->deleteRequests = [
            $this->deleteRequest
        ];

        $this->adapter = new ConcreteRequestEntityAdapter($this->requestEntityAdapterMock, $this->entityAdapterMock);

        $this->requestEntityAdapterHelper = new RequestEntityAdapterHelper($this, $this->requestEntityAdapterMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
        $this->entityHelper = new EntityHelper($this, $this->simpleEntityMock);
        $this->uuidHelper = new UuidHelper($this, $this->uuidMock);

    }

    public function tearDown() {

    }

    public function testFromEntityToInsertRequests_Success() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->simpleEntityMock, false);
        $this->requestEntityAdapterHelper->expectsFromEntityToInsertRequests_Success($this->subRequests, $this->simpleEntityMock);

        $requests = $this->adapter->fromEntityToInsertRequests($this->simpleEntityMock);

        $this->assertEquals(array_merge([$this->insertRequest], $this->subRequests), $requests);

    }

    public function testFromEntityToInsertRequests_throwsRequestEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->simpleEntityMock, false);
        $this->requestEntityAdapterHelper->expectsFromEntityToInsertRequests_throwsRequestEntityException($this->simpleEntityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToInsertRequests($this->simpleEntityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToInsertRequests_throwsEntityException_throwsRequestEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);
        $this->entityAdapterHelper->expectsFromEntityToData_throwsEntityException($this->simpleEntityMock, false);

        $asserted = false;
        try {

            $this->adapter->fromEntityToInsertRequests($this->simpleEntityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToInsertRequests_Success() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->simpleEntityMock, false);
        $this->requestEntityAdapterHelper->expectsFromEntityToInsertRequests_Success($this->subRequests, $this->simpleEntityMock);

        $requests = $this->adapter->fromEntitiesToInsertRequests([$this->simpleEntityMock]);

        $this->assertEquals(array_merge([$this->insertRequest], $this->subRequests), $requests);

    }

    public function testFromEntitiesToInsertRequests_throwsRequestEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->simpleEntityMock, false);
        $this->requestEntityAdapterHelper->expectsFromEntityToInsertRequests_throwsRequestEntityException($this->simpleEntityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToInsertRequests([$this->simpleEntityMock]);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToInsertRequests_throwsEntityException_throwsRequestEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);
        $this->entityAdapterHelper->expectsFromEntityToData_throwsEntityException($this->simpleEntityMock, false);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToInsertRequests([$this->simpleEntityMock]);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToUpdateRequests_Success() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGetHumanReadable_multiple_Success([$this->humanReadableUuid, $this->humanReadableUuid]);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);

        $this->entityAdapterMock->expects($this->exactly(2))
                                    ->method('fromEntityToData')
                                    ->with($this->logicalOr(
                                        $this->simpleEntityMock,
                                        $this->simpleEntityMock
                                    ))
                                    ->will($this->onConsecutiveCalls(
                                        $this->data,
                                        $this->originalData
                                    ));


        $this->uuidHelper->expectsGet_Success($this->uuid);
        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_Success($this->subRequests, $this->simpleEntityMock, $this->simpleEntityMock);

        $request = $this->adapter->fromEntityToUpdateRequests($this->simpleEntityMock, $this->simpleEntityMock);

        $this->assertEquals(array_merge($this->subRequests, [$this->updateRequest]), $request);

    }

    public function testFromEntityToUpdateRequests_throwsRequestEntityException() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGetHumanReadable_multiple_Success([$this->humanReadableUuid, $this->humanReadableUuid]);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);

        $this->entityAdapterMock->expects($this->exactly(2))
                                    ->method('fromEntityToData')
                                    ->with($this->logicalOr(
                                        $this->simpleEntityMock,
                                        $this->simpleEntityMock
                                    ))
                                    ->will($this->onConsecutiveCalls(
                                        $this->data,
                                        $this->originalData
                                    ));

        $this->uuidHelper->expectsGet_Success($this->uuid);
        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_throwsRequestEntityException($this->simpleEntityMock, $this->simpleEntityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToUpdateRequests($this->simpleEntityMock, $this->simpleEntityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToUpdateRequests_originalEntityHasDifferentUuidThanUpdatedEntity_throwsRequestEntityException() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGetHumanReadable_multiple_Success([$this->humanReadableUuid, 'dca2c2d5-9edc-4e38-82b5-b71957a7e4cd']);

        $asserted = false;
        try {

            $this->adapter->fromEntityToUpdateRequests($this->simpleEntityMock, $this->simpleEntityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToUpdateRequests_originalEntityHasDifferentClassThenUpdatedEntity_throwsRequestEntityException() {

        $asserted = false;
        try {

            $this->adapter->fromEntityToUpdateRequests($this->simpleEntityMock, $this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToUpdateRequests_Success() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGetHumanReadable_multiple_Success([$this->humanReadableUuid, $this->humanReadableUuid]);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);

        $this->entityAdapterMock->expects($this->exactly(2))
                                    ->method('fromEntityToData')
                                    ->with($this->logicalOr(
                                        $this->simpleEntityMock,
                                        $this->simpleEntityMock
                                    ))
                                    ->will($this->onConsecutiveCalls(
                                        $this->data,
                                        $this->originalData
                                    ));

        $this->uuidHelper->expectsGet_Success($this->uuid);
        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_Success($this->subRequests, $this->simpleEntityMock, $this->simpleEntityMock);

        $requests = $this->adapter->fromEntitiesToUpdateRequests([$this->simpleEntityMock], [$this->simpleEntityMock]);

        $this->assertEquals(array_merge($this->subRequests, [$this->updateRequest]), $requests);

    }

    public function testFromEntitiesToUpdateRequests_throwsRequestEntityException() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGetHumanReadable_multiple_Success([$this->humanReadableUuid, $this->humanReadableUuid]);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);

        $this->entityAdapterMock->expects($this->exactly(2))
                                    ->method('fromEntityToData')
                                    ->with($this->logicalOr(
                                        $this->simpleEntityMock,
                                        $this->simpleEntityMock
                                    ))
                                    ->will($this->onConsecutiveCalls(
                                        $this->data,
                                        $this->originalData
                                    ));

        $this->uuidHelper->expectsGet_Success($this->uuid);
        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_throwsRequestEntityException($this->simpleEntityMock, $this->simpleEntityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToUpdateRequests([$this->simpleEntityMock], [$this->simpleEntityMock]);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToUpdateRequests_originalEntityHasDifferentUuidThanUpdatedEntity_throwsRequestEntityException() {

        $this->entityHelper->expectsGetUuid_multiple_Success([$this->uuidMock, $this->uuidMock]);
        $this->uuidHelper->expectsGetHumanReadable_multiple_Success([$this->humanReadableUuid, 'dca2c2d5-9edc-4e38-82b5-b71957a7e4cd']);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToUpdateRequests([$this->simpleEntityMock], [$this->simpleEntityMock]);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToUpdateRequests_withDifferentEntities_throwsRequestEntityException() {

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToUpdateRequests([$this->simpleEntityMock], [$this->simpleEntityMock, $this->simpleEntityMock]);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToDeleteRequests_Success() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->uuid);
        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_Success($this->subRequests, $this->simpleEntityMock);

        $requests = $this->adapter->fromEntityToDeleteRequests($this->simpleEntityMock);

        $this->assertEquals(array_merge($this->subRequests, [$this->deleteRequest]), $requests);

    }

    public function testFromEntityToDeleteRequests_throwsRequestEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->uuid);
        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_throwsRequestEntityException($this->simpleEntityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToDeleteRequests($this->simpleEntityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToDeleteRequests_throwsEntityException_throwsRequestEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_throwsEntityException($this->simpleEntityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToDeleteRequests($this->simpleEntityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToDeleteRequests_Success() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->uuid);
        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_Success($this->subRequests, $this->simpleEntityMock);

        $request = $this->adapter->fromEntitiesToDeleteRequests([$this->simpleEntityMock]);

        $this->assertEquals(array_merge($this->subRequests, [$this->deleteRequest]), $request);

    }

    public function testFromEntitiesToDeleteRequests_throwsRequestEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->simpleEntityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGet_Success($this->uuid);
        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_throwsRequestEntityException($this->simpleEntityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToDeleteRequests([$this->simpleEntityMock]);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToDeleteRequests_throwsEntityException_throwsRequestEntityException() {

        $this->entityAdapterHelper->expectsFromEntityToContainerName_throwsEntityException($this->simpleEntityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToDeleteRequests([$this->simpleEntityMock]);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntityToParentDeleteRequests_Success() {

        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_Success($this->deleteRequests, $this->entityMock);

        $parentDeleteRequests = $this->adapter->fromEntityToParentDeleteRequests($this->entityMock);

        $this->assertEquals($this->deleteRequests, $parentDeleteRequests);

    }

    public function testFromEntityToParentDeleteRequests_throwsRequestEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_throwsRequestEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->adapter->fromEntityToParentDeleteRequests($this->entityMock);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromEntitiesToParentDeleteRequests_Success() {

        $this->requestEntityAdapterHelper->expectsFromEntitiesToDeleteRequests_Success($this->deleteRequests, $this->entities);

        $parentDeleteRequests = $this->adapter->fromEntitiesToParentDeleteRequests($this->entities);

        $this->assertEquals($this->deleteRequests, $parentDeleteRequests);

    }

    public function testFromEntitiesToParentDeleteRequests_throwsRequestEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntitiesToDeleteRequests_throwsRequestEntityException($this->entities);

        $asserted = false;
        try {

            $this->adapter->fromEntitiesToParentDeleteRequests($this->entities);

        } catch (RequestEntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
