<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Services;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Services\PDOEntityService;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Services\PDOServiceHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\RequestEntityAdapterHelper;

final class PDOEntityServiceTest extends \PHPUnit_Framework_TestCase {
    private $requestEntityAdapterMock;
    private $simpleEntityMock;
    private $pdoServiceMock;
    private $pdoMock;
    private $data;
    private $updateData;
    private $deleteData;
    private $insertRequest;
    private $updateRequest;
    private $deleteRequest;
    private $service;
    private $requestEntityAdapterHelper;
    private $pdoServiceHelper;
    public function setUp() {
        
        $this->requestEntityAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Entities\Adapters\RequestEntityAdapter');
        $this->simpleEntityMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Objects\SimpleEntity');
        $this->pdoServiceMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\PDOService');
        $this->pdoMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO');

        $this->uuid = hex2bin(str_replace('-', '', '9e825c47-f8a2-427b-ba51-2815ddd3dd6c'));
        $this->containerName = 'simple_entity';

        $this->data = [
            'uuid' => $this->uuid,
            'created_on' => time(),
            'title' => 'Just a title'
        ];

        $this->updateData = [
            'uuid' => $this->uuid,
            '__original_uuid__' => $this->uuid,
            'created_on' => time(),
            'title' => 'Just a title'
        ];

        $this->deleteData = [
            'uuid' => $this->uuid
        ];

        $this->insertRequest = [
            'query' => 'insert into '.$this->containerName.' (uuid, created_on, title) values(:uuid, :created_on, :title);',
            'params' => $this->data
        ];

        $this->updateRequest = [
            'query' => 'update '.$this->containerName.' set uuid = :uuid, created_on = :created_on, title = :title where uuid = :__original_uuid__;',
            'params' => $this->updateData
        ];

        $this->deleteRequest = [
            'query' => 'delete from '.$this->containerName.' where uuid = :uuid;',
            'params' => $this->deleteData
        ];

        $this->service = new PDOEntityService($this->requestEntityAdapterMock, $this->pdoServiceMock);

        $this->requestEntityAdapterHelper = new RequestEntityAdapterHelper($this, $this->requestEntityAdapterMock);
        $this->pdoServiceHelper = new PDOServiceHelper($this, $this->pdoServiceMock);
    }

    public function tearDown() {

    }

    public function testInsert_Success() {

        $this->requestEntityAdapterHelper->expectsFromEntityToInsertRequests_Success([$this->insertRequest], $this->simpleEntityMock);
        $this->pdoServiceHelper->expectsQueries_Success($this->pdoMock, [$this->insertRequest]);

        $this->service->insert($this->simpleEntityMock);

    }

    public function testInsert_throwsPDOException_throwsEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntityToInsertRequests_Success([$this->insertRequest], $this->simpleEntityMock);
        $this->pdoServiceHelper->expectsQueries_throwsPDOException([$this->insertRequest]);

        $asserted = false;
        try {

            $this->service->insert($this->simpleEntityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testInsert_throwsRequestEntityException_throwsEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntityToInsertRequests_throwsRequestEntityException($this->simpleEntityMock);

        $asserted = false;
        try {

            $this->service->insert($this->simpleEntityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testUpdate_Success() {

        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_Success([$this->updateRequest], $this->simpleEntityMock, $this->simpleEntityMock);
        $this->pdoServiceHelper->expectsQueries_Success($this->pdoMock, [$this->updateRequest]);

        $this->service->update($this->simpleEntityMock, $this->simpleEntityMock);

    }

    public function testUpdate_throwsPDOException_throwsEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_Success([$this->updateRequest], $this->simpleEntityMock, $this->simpleEntityMock);
        $this->pdoServiceHelper->expectsQueries_throwsPDOException([$this->updateRequest]);

        $asserted = false;
        try {

            $this->service->update($this->simpleEntityMock, $this->simpleEntityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testUpdate_throwsRequestEntityException_throwsEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntityToUpdateRequests_throwsRequestEntityException($this->simpleEntityMock, $this->simpleEntityMock);

        $asserted = false;
        try {

            $this->service->update($this->simpleEntityMock, $this->simpleEntityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testDelete_Success() {

        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_Success([$this->deleteRequest], $this->simpleEntityMock);
        $this->pdoServiceHelper->expectsQueries_Success($this->pdoMock, [$this->deleteRequest]);

        $this->service->delete($this->simpleEntityMock);

    }

    public function testDelete_throwsPDOException_throwsEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_Success([$this->deleteRequest], $this->simpleEntityMock);
        $this->pdoServiceHelper->expectsQueries_throwsPDOException([$this->deleteRequest]);

        $asserted = false;
        try {

            $this->service->delete($this->simpleEntityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testDelete_throwsRequestEntityException_throwsEntityException() {

        $this->requestEntityAdapterHelper->expectsFromEntityToDeleteRequests_throwsRequestEntityException($this->simpleEntityMock);

        $asserted = false;
        try {

            $this->service->delete($this->simpleEntityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
