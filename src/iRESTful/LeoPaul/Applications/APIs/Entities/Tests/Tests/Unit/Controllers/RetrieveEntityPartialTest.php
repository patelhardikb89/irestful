<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Unit\Controllers;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Controllers\RetrieveEntityPartialSet;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityPartialSetAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories\EntityPartialSetRepositoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityPartialSetAdapterFactoryHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories\EntityPartialSetRepositoryFactoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters\ControllerResponseAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRequestHelper;

final class RetrieveEntityPartialSetTest extends \PHPUnit_Framework_TestCase {
    private $controllerResponseAdapterMock;
    private $controllerResponseMock;
    private $httpRequestMock;
    private $entityPartialSetRepositoryFactoryMock;
    private $entityPartialSetRepositoryMock;
    private $entityPartialSetMock;
    private $entityPartialSetAdapterFactoryMock;
    private $entityPartialSetAdapterMock;
    private $index;
    private $amount;
    private $totalAmount;
    private $container;
    private $ordering;
    private $input;
    private $inputWithOrdering;
    private $criteria;
    private $criteriaWithOrdering;
    private $data;
    private $controller;
    private $controllerResponseAdapterHelper;
    private $httpRequestHelper;
    private $entityPartialSetRepositoryFactoryHelper;
    private $entityPartialSetRepositoryHelper;
    private $entityPartialSetAdapterFactoryHelper;
    private $entityPartialSetAdapterHelper;
    public function setUp() {
        $this->controllerResponseAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter');
        $this->controllerResponseMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\ControllerResponse');
        $this->httpRequestMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest');
        $this->entityPartialSetRepositoryFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory');
        $this->entityPartialSetRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository');
        $this->entityPartialSetMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet');
        $this->entityPartialSetAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\EntityPartialSetAdapterFactory');
        $this->entityPartialSetAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter');

        $this->index = rand(0, 100);
        $this->amount = 2;
        $this->totalAmount = $this->index + $this->amount + rand(1, 500);
        $this->container = 'my_container';

        $this->ordering = [
            'name' => 'created_on',
            'is_ascending' => true
        ];

        $this->input = [
            'index' => $this->index,
            'amount' => $this->amount,
            'container' => $this->container
        ];

        $this->inputWithOrdering = [
            'index' => $this->index,
            'amount' => $this->amount,
            'container' => $this->container,
            'ordering' => $this->ordering
        ];

        $this->criteria = [
            'index' => $this->index,
            'amount' => $this->amount,
            'container' => $this->container
        ];

        $this->criteriaWithOrdering = [
            'index' => $this->index,
            'amount' => $this->amount,
            'container' => $this->container,
            'ordering' => $this->ordering
        ];

        $this->data = [
            'index' => $this->index,
            'amount' => $this->amount,
            'total_amount' => $this->totalAmount,
            'entities' => [
                [
                    'uuid' => '54b930ef-bb37-422d-89c2-01eec3f7f7e9',
                    'title' => 'Some Title',
                    'created_on' => time()
                ],
                [
                    'uuid' => '1cfdd015-4269-42e8-b846-353f293b5042',
                    'title' => 'Another Title',
                    'created_on' => time()
                ]
            ]
        ];

        $this->controller = new RetrieveEntityPartialSet($this->controllerResponseAdapterMock, $this->entityPartialSetRepositoryFactoryMock, $this->entityPartialSetAdapterFactoryMock);

        $this->controllerResponseAdapterHelper = new ControllerResponseAdapterHelper($this, $this->controllerResponseAdapterMock);
        $this->httpRequestHelper = new HttpRequestHelper($this, $this->httpRequestMock);
        $this->entityPartialSetRepositoryFactoryHelper = new EntityPartialSetRepositoryFactoryHelper($this, $this->entityPartialSetRepositoryFactoryMock);
        $this->entityPartialSetRepositoryHelper = new EntityPartialSetRepositoryHelper($this, $this->entityPartialSetRepositoryMock);
        $this->entityPartialSetAdapterFactoryHelper = new EntityPartialSetAdapterFactoryHelper($this, $this->entityPartialSetAdapterFactoryMock);
        $this->entityPartialSetAdapterHelper = new EntityPartialSetAdapterHelper($this, $this->entityPartialSetAdapterMock);
    }

    public function tearDown() {

    }

    public function testExecute_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $this->entityPartialSetRepositoryFactoryHelper->expectsCreate_Success($this->entityPartialSetRepositoryMock);
        $this->entityPartialSetRepositoryHelper->expectsRetrieve_Success($this->entityPartialSetMock, $this->criteria);

        $this->entityPartialSetAdapterFactoryHelper->expectsCreate_Success($this->entityPartialSetAdapterMock);
        $this->entityPartialSetAdapterHelper->expectsFromEntityPartialSetToData_Success($this->data, $this->entityPartialSetMock);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_withOrdering_Success() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithOrdering);

        $this->entityPartialSetRepositoryFactoryHelper->expectsCreate_Success($this->entityPartialSetRepositoryMock);
        $this->entityPartialSetRepositoryHelper->expectsRetrieve_Success($this->entityPartialSetMock, $this->criteriaWithOrdering);

        $this->entityPartialSetAdapterFactoryHelper->expectsCreate_Success($this->entityPartialSetAdapterMock);
        $this->entityPartialSetAdapterHelper->expectsFromEntityPartialSetToData_Success($this->data, $this->entityPartialSetMock);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_Success($this->controllerResponseMock, $this->data);

        $response = $this->controller->execute($this->httpRequestMock);

        $this->assertEquals($this->controllerResponseMock, $response);

    }

    public function testExecute_withOrdering_throwsControllerResponseException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->inputWithOrdering);

        $this->entityPartialSetRepositoryFactoryHelper->expectsCreate_Success($this->entityPartialSetRepositoryMock);
        $this->entityPartialSetRepositoryHelper->expectsRetrieve_Success($this->entityPartialSetMock, $this->criteriaWithOrdering);

        $this->entityPartialSetAdapterFactoryHelper->expectsCreate_Success($this->entityPartialSetAdapterMock);
        $this->entityPartialSetAdapterHelper->expectsFromEntityPartialSetToData_Success($this->data, $this->entityPartialSetMock);

        $this->controllerResponseAdapterHelper->expectsFromDataToControllerResponse_throwsControllerResponseException($this->data);

        $asserted = false;
        try {

            $this->controller->execute($this->httpRequestMock);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExecute_throwsEntityPartialSetException_throwsServerException() {

        $this->httpRequestHelper->expectsHasParameters_Success(true);
        $this->httpRequestHelper->expectsGetParameters_Success($this->input);

        $this->entityPartialSetRepositoryFactoryHelper->expectsCreate_Success($this->entityPartialSetRepositoryMock);
        $this->entityPartialSetRepositoryHelper->expectsRetrieve_Success($this->entityPartialSetMock, $this->criteria);

        $this->entityPartialSetAdapterFactoryHelper->expectsCreate_Success($this->entityPartialSetAdapterMock);
        $this->entityPartialSetAdapterHelper->expectsFromEntityPartialSetToData_throwsEntityPartialSetException($this->entityPartialSetMock);

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

    public function testExecute_withoutIndexInInput_throwsInvalidRequestException() {

        unset($this->input['index']);

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

    public function testExecute_withoutAmountInInput_throwsInvalidRequestException() {

        unset($this->input['amount']);

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
