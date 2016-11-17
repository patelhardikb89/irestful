<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Unit\Controllers;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\RetrieveEntity;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityAdapterFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityRepositoryFactoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters\ControllerResponseAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRequestHelper;

final class RetrieveEntityTest extends \PHPUnit_Framework_TestCase {
    private $controllerResponseAdapterMock;
    private $controllerResponseMock;
    private $httpRequestMock;
    private $entityRepositoryFactoryMock;
    private $entityRepositoryMock;
    private $entityMock;
    private $entityAdapterFactoryMock;
    private $entityAdapterMock;
    private $uuid;
    private $container;
    private $keynames;
    private $keyname;
    private $inputWithUuid;
    private $inputWithKeynames;
    private $inputWithKeyname;
    private $criteriaWithUuid;
    private $criteriaWithKeynames;
    private $criteriaWithKeyname;
    private $data;
    private $controller;
    private $controllerResponseAdapterHelper;
    private $httpRequestHelper;
    private $entityRepositoryFactoryHelper;
    private $entityRepositoryHelper;
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
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->uuid = '0d19e6ba-80df-42af-bedd-3900e6aa09c0';
        $this->container = 'my_container';

        $this->keyname = [
            'name' => 'slug',
            'value' => 'some_value'
        ];

        $this->keynames = [
            $this->keyname,
            [
                'name' => 'title',
                'value' => 'Some Title'
            ]
        ];

        $this->inputWithUuid = [
            'uuid' => $this->uuid,
            'container' => $this->container
        ];

        $this->inputWithKeyname = [
            'container' => $this->container,
            'name' => 'slug',
            'value' => 'some_value'
        ];

        $this->inputWithKeynames = [
            'container' => $this->container,
            'name' => 'slug,title',
            'value' => 'some_value,Some Title'
        ];

        $this->criteriaWithUuid = [
            'uuid' => $this->uuid,
            'container' => $this->container
        ];

        $this->criteriaWithKeyname = [
            'container' => $this->container,
            'keyname' => $this->keyname
        ];

        $this->criteriaWithKeynames = [
            'container' => $this->container,
            'keynames' => $this->keynames
        ];

        $this->data = [
            'uuid' => $this->uuid,
            'slug' => 'some_value',
            'title' => 'Some Title',
            'created_on' => time()
        ];

        $this->controller = new RetrieveEntity($this->controllerResponseAdapterMock, $this->entityRepositoryFactoryMock, $this->entityAdapterFactoryMock);

        $this->controllerResponseAdapterHelper = new ControllerResponseAdapterHelper($this, $this->controllerResponseAdapterMock);
        $this->httpRequestHelper = new HttpRequestHelper($this, $this->httpRequestMock);
        $this->entityRepositoryFactoryHelper = new EntityRepositoryFactoryHelper($this, $this->entityRepositoryFactoryMock);
        $this->entityRepositoryHelper = new EntityRepositoryHelper($this, $this->entityRepositoryMock);
        $this->entityAdapterFactoryHelper = new EntityAdapterFactoryHelper($this, $this->entityAdapterFactoryMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
    }

    public function tearDown() {

    }

    public function testExecute_withUuidInput_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithUuid);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entityRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entityMock, $this->criteriaWithUuid);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_withKeynameInput_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithKeyname);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entityRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entityMock, $this->criteriaWithKeyname);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_withKeynamesInput_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithKeynames);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entityRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entityMock, $this->criteriaWithKeynames);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_withKeynamesInput_throwsControllerResponseException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithKeynames);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entityRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entityMock, $this->criteriaWithKeynames);

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

    public function testExecute_withUuidInput_throwsEntityException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithUuid);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entityRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entityMock, $this->criteriaWithUuid);

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

    public function testExecute_withUuidInput_retrieveReturnedNull_throwsNotFoundException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithUuid);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entityRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_returnedNull_Success($this->criteriaWithUuid);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (NotFoundException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExecute_withoutQueryParameters_missingParameters_throwsInvalidRequestException() {

        $this->httpRequestHelper->expectsHasParameters_Success(false);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (InvalidRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExecute_withUuidInput_withoutContainer_throwsInvalidRequestException() {

        unset($this->inputWithUuid['container']);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (InvalidRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExecute_withUuidInput_withoutRetrievalMethod_throwsInvalidRequestException() {

        unset($this->inputWithUuid['uuid']);

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithUuid);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (InvalidRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
