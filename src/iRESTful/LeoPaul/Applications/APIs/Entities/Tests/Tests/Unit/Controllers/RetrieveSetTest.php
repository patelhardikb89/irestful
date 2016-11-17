<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Unit\Controllers;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\RetrieveSet;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntitySetRepositoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityAdapterFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntitySetRepositoryFactoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters\ControllerResponseAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRequestHelper;

final class RetrieveSetTest extends \PHPUnit_Framework_TestCase {
    private $controllerResponseAdapterMock;
    private $controllerResponseMock;
    private $httpRequestMock;
    private $entitySetRepositoryFactoryMock;
    private $entitySetRepositoryMock;
    private $entityMock;
    private $entityAdapterFactoryMock;
    private $entityAdapterMock;
    private $container;
    private $keyname;
    private $ordering;
    private $inputWithUuids;
    private $inputWithUuidsOrdering;
    private $inputWithKeyname;
    private $inputWithKeynameOrdering;
    private $criteriaWithUuids;
    private $criteriaWithUuidsOrdering;
    private $criteriaWithKeyname;
    private $critriaWithKeynameOrdering;
    private $entities;
    private $data;
    private $controller;
    private $controllerResponseAdapterHelper;
    private $httpRequestHelper;
    private $entitySetRepositoryFactoryHelper;
    private $entitySetRepositoryHelper;
    private $entityAdapterFactoryHelper;
    private $entityAdapterHelper;
    public function setUp() {
        $this->controllerResponseAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter');
        $this->controllerResponseMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\ControllerResponse');
        $this->httpRequestMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest');
        $this->entityAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entitySetRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory');
        $this->entitySetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\EntitySetRepository');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->container = 'my_container';
        $this->keyname = [
            'name' => 'slug',
            'value' => 'my-slug'
        ];

        $this->ordering = [
            'name' => 'created_on',
            'is_ascending' => true
        ];

        $this->inputWithUuids = [
            'container' => $this->container,
            'uuids' => '66ebf0a6-a6fb-4f55-8c1e-30fafa8cd72f,0c9d168e-b063-49e4-b196-662e09c6b1b6'
        ];

        $this->inputWithUuidsOrdering = [
            'container' => $this->container,
            'uuids' => '66ebf0a6-a6fb-4f55-8c1e-30fafa8cd72f,0c9d168e-b063-49e4-b196-662e09c6b1b6',
            'ordering' => $this->ordering
        ];

        $this->inputWithKeyname = [
            'container' => $this->container,
            'name' => 'slug',
            'value' => 'my-slug'
        ];

        $this->inputWithKeynameOrdering = [
            'container' => $this->container,
            'name' => 'slug',
            'value' => 'my-slug',
            'ordering' => $this->ordering
        ];

        $this->criteriaWithUuids = [
            'container' => $this->container,
            'uuids' => '66ebf0a6-a6fb-4f55-8c1e-30fafa8cd72f,0c9d168e-b063-49e4-b196-662e09c6b1b6'
        ];

        $this->criteriaWithUuidsOrdering = [
            'container' => $this->container,
            'uuids' => '66ebf0a6-a6fb-4f55-8c1e-30fafa8cd72f,0c9d168e-b063-49e4-b196-662e09c6b1b6',
            'ordering' => $this->ordering
        ];

        $this->criteriaWithKeyname = [
            'container' => $this->container,
            'keyname' => $this->keyname
        ];

        $this->criteriaWithKeynameOrdering = [
            'container' => $this->container,
            'keyname' => $this->keyname,
            'ordering' => $this->ordering
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

        $this->controller = new RetrieveSet($this->controllerResponseAdapterMock, $this->entitySetRepositoryFactoryMock, $this->entityAdapterFactoryMock);

        $this->controllerResponseAdapterHelper = new ControllerResponseAdapterHelper($this, $this->controllerResponseAdapterMock);
        $this->httpRequestHelper = new HttpRequestHelper($this, $this->httpRequestMock);
        $this->entityRepositoryFactoryHelper = new EntitySetRepositoryFactoryHelper($this, $this->entitySetRepositoryFactoryMock);
        $this->entityRepositoryHelper = new EntitySetRepositoryHelper($this, $this->entitySetRepositoryMock);
        $this->entityAdapterFactoryHelper = new EntityAdapterFactoryHelper($this, $this->entityAdapterFactoryMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);

    }

    public function tearDown() {

    }

    public function testExecute_withUuids_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithUuids);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entitySetRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteriaWithUuids);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntitiesToData_Success($this->data, $this->entities, true);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_withUuidsOrdering_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithUuidsOrdering);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entitySetRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteriaWithUuidsOrdering);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntitiesToData_Success($this->data, $this->entities, true);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_withKeyname_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithKeyname);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entitySetRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteriaWithKeyname);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntitiesToData_Success($this->data, $this->entities, true);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_withKeynameOrdering_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithKeynameOrdering);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entitySetRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteriaWithKeynameOrdering);

        $this->entityAdapterFactoryHelper->expectsCreate_Success($this->entityAdapterMock);
        $this->entityAdapterHelper->expectsFromEntitiesToData_Success($this->data, $this->entities, true);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_withKeynameOrdering_throwsControllerResponseException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithKeynameOrdering);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entitySetRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteriaWithKeynameOrdering);

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

    public function testExecute_withUuids_throwsEntityException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithUuids);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entitySetRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_Success($this->entities, $this->criteriaWithUuids);

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

    public function testExecute_withUuids_throwsEntitySetException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithUuids);

        $this->entityRepositoryFactoryHelper->expectsCreate_Success($this->entitySetRepositoryMock);
        $this->entityRepositoryHelper->expectsRetrieve_throwsEntitySetException($this->criteriaWithUuids);

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

    public function testExecute_withUuids_withoutContainer_throwsInvalidRequestException() {

        unset($this->inputWithUuids['container']);

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithUuids);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (InvalidRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExecute_withUuids_withoutCriteria_throwsInvalidRequestException() {

        unset($this->inputWithUuids['uuids']);

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithUuids);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (InvalidRequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
