<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Unit\Services;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Services\HttpEntityService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityAdapterFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Applications\HttpApplicationHelper;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Objects\UuidHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects\EntityHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpResponseHelper;

final class HttpEntityServiceTest extends \PHPUnit_Framework_TestCase {
    private $entityAdapterFactoryMock;
    private $entityAdapterMock;
    private $entityMock;
    private $httpApplicationMock;
    private $httpResponseMock;
    private $uuidMock;
    private $uuid;
    private $data;
    private $containerName;
    private $port;
    private $headers;
    private $insertHttpRequestData;
    private $insertHttpRequestDataWithPortHeaders;
    private $updatetHttpRequestData;
    private $updatetHttpRequestDataWithPortHeaders;
    private $deleteHttpRequestData;
    private $deleteHttpRequestDataWithPortHeaders;
    private $service;
    private $serviceWithPortHeaders;
    private $entityAdapterFactoryHelper;
    private $entityAdapterHelper;
    private $httpApplicationHelper;
    private $httpResponseHelper;
    private $entityHelper;
    private $uuidHelper;
    public function setUp() {
        $this->entityAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');
        $this->httpApplicationMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication');
        $this->httpResponseMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse');
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');

        $this->uuid = '63d12d8a-cdb4-4eae-825d-010bac022e30';

        $this->port = rand(1, 1000);
        $this->headers = [
            'some' => 'headers'
        ];

        $this->data = [
            'uuid' => '8e274a14-ed16-46f5-a2ce-aec0f8fdab46',
            'title' => 'Some title',
            'created_on' => time()
        ];

        $this->containerName = 'my_container';

        $this->insertHttpRequestData = [
            'uri' => '/'.$this->containerName,
            'request_parameters' => $this->data,
            'method' => 'post',
            'port' => 80,
            'headers' => null
        ];

        $this->insertHttpRequestDataWithPortHeaders = [
            'uri' => '/'.$this->containerName,
            'request_parameters' => $this->data,
            'method' => 'post',
            'port' => $this->port,
            'headers' => $this->headers
        ];

        $this->updatetHttpRequestData = [
            'uri' => '/'.$this->containerName.'/'.$this->uuid,
            'request_parameters' => $this->data,
            'method' => 'put',
            'port' => 80,
            'headers' => null
        ];

        $this->updatetHttpRequestDataWithPortHeaders = [
            'uri' => '/'.$this->containerName.'/'.$this->uuid,
            'request_parameters' => $this->data,
            'method' => 'put',
            'port' => $this->port,
            'headers' => $this->headers
        ];

        $this->deleteHttpRequestData = [
            'uri' => '/'.$this->containerName.'/'.$this->uuid,
            'method' => 'delete',
            'port' => 80,
            'headers' => null
        ];

        $this->deleteHttpRequestDataWithPortHeaders = [
            'uri' => '/'.$this->containerName.'/'.$this->uuid,
            'method' => 'delete',
            'port' => $this->port,
            'headers' => $this->headers
        ];

        $this->service = new HttpEntityService($this->entityAdapterFactoryMock, $this->httpApplicationMock);
        $this->serviceWithPortHeaders = new HttpEntityService($this->entityAdapterFactoryMock, $this->httpApplicationMock, $this->port, $this->headers);

        $this->entityAdapterFactoryHelper = new EntityAdapterFactoryHelper($this, $this->entityAdapterFactoryMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
        $this->httpApplicationHelper = new HttpApplicationHelper($this, $this->httpApplicationMock);
        $this->httpResponseHelper = new HttpResponseHelper($this, $this->httpResponseMock);
        $this->entityHelper = new EntityHelper($this, $this->entityMock);
        $this->uuidHelper = new UuidHelper($this, $this->uuidMock);

    }

    public function tearDown() {

    }

    public function testInsert_Success() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->insertHttpRequestData);
        $this->httpResponseHelper->expectsGetCode_Success(200);

        $this->service->insert($this->entityMock);
    }

    public function testInsert_with404HttpCode_throwsEntityException() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->insertHttpRequestData);
        $this->httpResponseHelper->expectsGetCode_Success(404);
        $this->httpResponseHelper->expectsGetContent_Success('Not found!');

        $asserted = false;
        $message = '';
        try {

            $this->service->insert($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
            $message = $exception->getMessage();
        }

        $this->assertTrue($asserted);
        $this->assertEquals('Not found!', $message);
    }

    public function testInsert_throwsHttpException_throwsEntityException() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->httpApplicationHelper->expectsExecute_throwsHttpException($this->insertHttpRequestData);

        $asserted = false;
        try {

            $this->service->insert($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testInsert_throwsEntityException() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->service->insert($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testInsert_withPortHeaders_Success() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->insertHttpRequestDataWithPortHeaders);
        $this->httpResponseHelper->expectsGetCode_Success(200);

        $this->serviceWithPortHeaders->insert($this->entityMock);
    }

    public function testUpdate_Success() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->updatetHttpRequestData);
        $this->httpResponseHelper->expectsGetCode_Success(200);

        $this->service->update($this->entityMock, $this->entityMock);
    }

    public function testUpdate_with404HttpCode_throwsEntityException() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->updatetHttpRequestData);
        $this->httpResponseHelper->expectsGetCode_Success(404);
        $this->httpResponseHelper->expectsGetContent_Success('Not found!');

        $asserted = false;
        $message = '';
        try {

            $this->service->update($this->entityMock, $this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
            $message = $exception->getMessage();
        }

        $this->assertTrue($asserted);
        $this->assertEquals('Not found!', $message);
    }

    public function testUpdate_throwsHttpException_throwsEntityException() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);
        $this->httpApplicationHelper->expectsExecute_throwsHttpException($this->updatetHttpRequestData);

        $asserted = false;
        try {

            $this->service->update($this->entityMock, $this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testUpdate_throwsEntityException() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->service->update($this->entityMock, $this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testUpdate_withPortHeaders_Success() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->updatetHttpRequestDataWithPortHeaders);
        $this->httpResponseHelper->expectsGetCode_Success(200);

        $this->serviceWithPortHeaders->update($this->entityMock, $this->entityMock);
    }

    public function testDelete_Success() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->deleteHttpRequestData);
        $this->httpResponseHelper->expectsGetCode_Success(200);

        $this->service->delete($this->entityMock);
    }

    public function testDelete_with404HttpCode_Success() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->deleteHttpRequestData);
        $this->httpResponseHelper->expectsGetCode_Success(404);
        $this->httpResponseHelper->expectsGetContent_Success('Not found!');

        $asserted = false;
        $message = '';
        try {

            $this->service->delete($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
            $message = $exception->getMessage();
        }

        $this->assertTrue($asserted);
        $this->assertEquals('Not found!', $message);
    }

    public function testDelete_throwsHttpException_throwsEntityException() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);
        $this->httpApplicationHelper->expectsExecute_throwsHttpException($this->deleteHttpRequestData);

        $asserted = false;
        try {

            $this->service->delete($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testDelete_throwsEntityException() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_throwsEntityException($this->entityMock);

        $asserted = false;
        try {

            $this->service->delete($this->entityMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testDelete_withPortHeaders_Success() {

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToContainerName_Success($this->containerName, $this->entityMock);
        $this->entityHelper->expectsGetUuid_Success($this->uuidMock);
        $this->uuidHelper->expectsGetHumanReadable_Success($this->uuid);
        $this->httpApplicationHelper->expectsExecute_Success($this->httpResponseMock, $this->deleteHttpRequestDataWithPortHeaders);
        $this->httpResponseHelper->expectsGetCode_Success(200);

        $this->serviceWithPortHeaders->delete($this->entityMock);
    }

}
