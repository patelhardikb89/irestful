<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Unit\Controllers;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\DeleteEntity;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Services\EntityServiceHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityRepositoryFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityServiceFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityAdapterFactoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters\ControllerResponseAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRequestHelper;

final class DeleteEntityTest extends \PHPUnit_Framework_TestCase {
    private $controllerResponseAdapterMock;
    private $controllerResponseMock;
    private $httpRequestMock;
    private $entityAdapterFactoryMock;
    private $entityAdapterMock;
    private $entityRepositoryFactoryMock;
    private $entityRepositoryMock;
    private $entityServiceFactoryMock;
    private $entityServiceMock;
    private $entityMock;
    private $uuid;
    private $container;
    private $input;
    private $criteria;
    private $data;
    private $controller;
    private $controllerResponseAdapterHelper;
    private $httpRequestHelper;
    private $entityRepositoryFactoryHelper;
    private $entityRepositoryHelper;
    private $entityServiceFactoryHelper;
    private $entityServiceHelper;
    private $entityAdapterFactoryHelper;
    private $entityAdapterHelper;
    public function setUp() {
        $this->controllerResponseAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter');
        $this->controllerResponseMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\ControllerResponse');
        $this->httpRequestMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest');
        $this->entityAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory');
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->entityServiceFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory');
        $this->entityServiceMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->uuid = '0d19e6ba-80df-42af-bedd-3900e6aa09c0';
        $this->container = 'my_container';

        $this->input = [
            'uuid' => $this->uuid,
            'container' => $this->container
        ];

        $this->criteria = [
            'uuid' => $this->uuid,
            'container' => $this->container
        ];

        $this->data = [
            'uuid' => $this->uuid,
            'title' => 'Some Title',
            'description' => 'Some Description',
            'created_on' => time()
        ];

        $this->controller = new DeleteEntity($this->controllerResponseAdapterMock, $this->entityRepositoryFactoryMock, $this->entityServiceFactoryMock, $this->entityAdapterFactoryMock);

        $this->controllerResponseAdapterHelper = new ControllerResponseAdapterHelper($this, $this->controllerResponseAdapterMock);
        $this->httpRequestHelper = new HttpRequestHelper($this, $this->httpRequestMock);
        $this->entityRepositoryFactoryHelper = new EntityRepositoryFactoryHelper($this, $this->entityRepositoryFactoryMock);
        $this->entityRepositoryHelper = new EntityRepositoryHelper($this, $this->entityRepositoryMock);
        $this->entityServiceFactoryHelper = new EntityServiceFactoryHelper($this, $this->entityServiceFactoryMock);
        $this->entityServiceHelper = new EntityServiceHelper($this, $this->entityServiceMock);
        $this->entityAdapterFactoryHelper = new EntityAdapterFactoryHelper($this, $this->entityAdapterFactoryMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
    }

    public function tearDown() {

    }

    public function testExecute_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entityRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entityMock, $this->criteria);

        $this->entityServiceFactoryHelper->expectsCreate_Success($this->entityServiceMock);
        $this->entityServiceHelper->expectsDelete_Success($this->entityMock);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_throwsControllerResponseException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entityRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entityMock, $this->criteria);

        $this->entityServiceFactoryHelper->expectsCreate_Success($this->entityServiceMock);
        $this->entityServiceHelper->expectsDelete_Success($this->entityMock);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_throwsControllerResponseException($this->data);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExecute_throwsEntityException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entityRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entityMock, $this->criteria);

        $this->entityServiceFactoryHelper->expectsCreate_Success($this->entityServiceMock);
        $this->entityServiceHelper->expectsDelete_Success($this->entityMock);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_throwsEntityException($this->entityMock, true);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExecute_retrieveReturnedNull_throwsNotFoundException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entityRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_returnedNull_Success($this->criteria);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (NotFoundException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExecute_withoutQueryParameters_hasMissingParameters_throwsInvalidRequestException() {

        $this->httpRequestHelper->expectsHasParameters_Success(false);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (InvalidRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExecute_withoutUuidInInput_throwsInvalidRequestException() {

        unset($this->input['uuid']);

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (InvalidRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExecute_withoutContainerInInput_throwsInvalidRequestException() {

        unset($this->input['container']);

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (InvalidRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
