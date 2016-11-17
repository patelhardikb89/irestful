<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Unit\Controllers;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\RetrieveRelation;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityRelationRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityAdapterFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityRelationRepositoryFactoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters\ControllerResponseAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRequestHelper;

final class RetrieveRelationTest extends \PHPUnit_Framework_TestCase {
    private $controllerResponseAdapterMock;
    private $controllerResponseMock;
    private $httpRequestMock;
    private $entityRelationRepositoryFactoryMock;
    private $entityRelationRepositoryMock;
    private $entityAdapterFactoryMock;
    private $entityAdapterMock;
    private $entityMock;
    private $input;
    private $criteria;
    private $data;
    private $entities;
    private $controller;
    private $controllerResponseAdapterHelper;
    private $httpRequestHelper;
    private $entityRelationRepositoryFactoryHelper;
    private $entityRelationRepositoryHelper;
    private $entityAdapterFactoryHelper;
    private $entityAdapterHelper;
    public function setUp() {
        $this->controllerResponseAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter');
        $this->controllerResponseMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\ControllerResponse');
        $this->httpRequestMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest');
        $this->entityAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityRelationRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory');
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->input = [
            'master_container' => 'roles',
            'slave_container' => 'permissions',
            'slave_property' => 'one_permission',
            'master_uuid' => 'a38325fd-090e-420b-948a-84c4aae6423a'
        ];

        $this->criteria = [
            'master_container' => 'roles',
            'slave_container' => 'permissions',
            'slave_property' => 'one_permission',
            'master_uuid' => 'a38325fd-090e-420b-948a-84c4aae6423a'
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->data = [
            [
                'uuid' => '66ebf0a6-a6fb-4f55-8c1e-30fafa8cd72f',
                'slug' => 'my-slug',
                'title' => 'Some Title',
                'created_on' => time()
            ],
            [
                'uuid' => '0c9d168e-b063-49e4-b196-662e09c6b1b6',
                'slug' => 'my-slug',
                'title' => 'Second Title',
                'created_on' => time()
            ]
        ];

        $this->controller = new RetrieveRelation($this->controllerResponseAdapterMock, $this->entityRelationRepositoryFactoryMock, $this->entityAdapterFactoryMock);

        $this->controllerResponseAdapterHelper = new ControllerResponseAdapterHelper($this, $this->controllerResponseAdapterMock);
        $this->httpRequestHelper = new HttpRequestHelper($this, $this->httpRequestMock);
        $this->entityRelationRepositoryHelper = new EntityRelationRepositoryHelper($this, $this->entityRelationRepositoryMock);
        $this->entityRelationRepositoryFactoryHelper = new EntityRelationRepositoryFactoryHelper($this, $this->entityRelationRepositoryFactoryMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
        $this->entityAdapterFactoryHelper = new EntityAdapterFactoryHelper($this, $this->entityAdapterFactoryMock);
    }

    public function tearDown() {

    }

    public function testExecute_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $this->entityRelationRepositoryFactoryHelper->expectsCreate_Success($this->entityRelationRepositoryMock);
        $this->entityRelationRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteria);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntitiesToData_Success($this->data, $this->entities, true);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_throwsControllerResponseException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $this->entityRelationRepositoryFactoryHelper->expectsCreate_Success($this->entityRelationRepositoryMock);
        $this->entityRelationRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteria);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntitiesToData_Success($this->data, $this->entities, true);

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

        $this->entityRelationRepositoryFactoryHelper->expectsCreate_Success($this->entityRelationRepositoryMock);
        $this->entityRelationRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteria);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntitiesToData_throwsEntityException($this->entities, true);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);


    }

    public function testExecute_throwsEntityRelationException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $this->entityRelationRepositoryFactoryHelper->expectsCreate_Success($this->entityRelationRepositoryMock);
        $this->entityRelationRepositoryHelper->expectsRetrieve_throwsEntityRelationException($this->criteria);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (ServerException $exception) {
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

    public function testExecute_withoutMasterContainer_throwsInvalidRequestException() {

        unset($this->input['master_container']);

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

    public function testExecute_withoutSlaveContainer_throwsInvalidRequestException() {

        unset($this->input['slave_container']);

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

    public function testExecute_withoutSlaveProperty_throwsInvalidRequestException() {

        unset($this->input['slave_property']);

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

    public function testExecute_withoutMasterUuid_throwsInvalidRequestException() {

        unset($this->input['master_uuid']);

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
