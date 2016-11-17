<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Unit\Controllers;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\InsertEntity;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Services\EntityServiceHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityServiceFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityAdapterFactoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters\ControllerResponseAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRequestHelper;

final class InsertEntityTest extends \PHPUnit_Framework_TestCase {
    private $controllerResponseAdapterMock;
    private $controllerResponseMock;
    private $httpRequestMock;
    private $entityServiceFactoryMock;
    private $entityServiceMock;
    private $entityAdapterFactoryMock;
    private $entityAdapterMock;
    private $entityMock;
    private $input;
    private $data;
    private $conversionData;
    private $controller;
    private $controllerResponseAdapterHelper;
    private $httpRequestHelper;
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
        $this->entityServiceFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory');
        $this->entityServiceMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->input = [
            'uuid' => '48bf53b6-9965-445a-a667-506342080834',
            'container' => 'my_container',
            'title' => 'Some Title',
            'description' => 'Some Description',
            'created_on' => time()
        ];

        $this->data = [
            'uuid' => '48bf53b6-9965-445a-a667-506342080834',
            'title' => 'Some Title',
            'description' => 'Some Description',
            'created_on' => time()
        ];

        $this->conversionData = [
            'container' => 'my_container',
            'data' => [
                'uuid' => '48bf53b6-9965-445a-a667-506342080834',
                'title' => 'Some Title',
                'description' => 'Some Description',
                'created_on' => time()
            ]
        ];

        $this->controller = new InsertEntity($this->controllerResponseAdapterMock, $this->entityServiceFactoryMock, $this->entityAdapterFactoryMock);

        $this->controllerResponseAdapterHelper = new ControllerResponseAdapterHelper($this, $this->controllerResponseAdapterMock);
        $this->httpRequestHelper = new HttpRequestHelper($this, $this->httpRequestMock);
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

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromDataToEntity_Success($this->entityMock, $this->conversionData);

        $this->entityServiceFactoryHelper->expectsCreate_Success($this->entityServiceMock);
        $this->entityServiceHelper->expectsInsert_Success($this->entityMock);

        $this->entityAdapterHelper->expectsFromEntityToData_Success($this->data, $this->entityMock, true);
        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);
    }

    public function testExecute_throwsControllerResponseException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromDataToEntity_Success($this->entityMock, $this->conversionData);

        $this->entityServiceFactoryHelper->expectsCreate_Success($this->entityServiceMock);
        $this->entityServiceHelper->expectsInsert_Success($this->entityMock);

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

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromDataToEntity_Success($this->entityMock, $this->conversionData);

        $this->entityServiceFactoryHelper->expectsCreate_Success($this->entityServiceMock);
        $this->entityServiceHelper->expectsInsert_Success($this->entityMock);

        $this->entityAdapterHelper->expectsFromEntityToData_throwsEntityException($this->entityMock, true);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);;

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testExecute_withoutQueryParameters_missingParameters_throwsInvalidRequestException() {

        $this->httpRequestHelper->expectsHasParameters_Success(false);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);;

        } catch (InvalidRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testExecute_withoutContainer_throwsInvalidRequestException() {

        unset($this->input['container']);

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);;

        } catch (InvalidRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
