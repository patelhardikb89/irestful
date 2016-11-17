<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\RequestSetAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Repositories\PDORepositoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Factories\PDOAdapterFactoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\PDOAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories\PDOEntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class PDOEntitySetRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $requestSetAdapterMock;
    private $pdoRepositoryMock;
    private $pdoAdapterFactoryMock;
    private $pdoAdapterMock;
    private $pdoMock;
    private $entityMock;
    private $containerName;
    private $criteria;
    private $request;
    private $entities;
    private $repository;
    private $pdoRepositoryHelper;
    private $requestSetAdapterHelper;
    private $pdoAdapterFactoryHelper;
    private $pdoAdapterHelper;
    public function setUp() {

        $this->requestSetAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Adapters\RequestSetAdapter');
        $this->pdoRepositoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository');
        $this->pdoAdapterFactoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Factories\PDOAdapterFactory');
        $this->pdoAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter');
        $this->pdoMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->containerName = 'my_container';

        $this->criteria = [
            'container' => $this->containerName,
            'some' => 'criteria'
        ];

        $this->request = [
            'some' => 'request'
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->repository = new PDOEntitySetRepository($this->pdoRepositoryMock, $this->requestSetAdapterMock, $this->pdoAdapterFactoryMock);

        $this->pdoRepositoryHelper = new PDORepositoryHelper($this, $this->pdoRepositoryMock);
        $this->requestSetAdapterHelper = new RequestSetAdapterHelper($this, $this->requestSetAdapterMock);
        $this->pdoAdapterFactoryHelper = new PDOAdapterFactoryHelper($this, $this->pdoAdapterFactoryMock);
        $this->pdoAdapterHelper = new PDOAdapterHelper($this, $this->pdoAdapterMock);

    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->requestSetAdapterHelper->expectsFromDataToEntitySetRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterFactoryHelper->expectsCreate_Success($this->pdoAdapterMock);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_Success($this->entities, $this->pdoMock, $this->containerName);

        $entities = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entities, $entities);

    }

    public function testRetrieve_withoutEntities_Success() {

        $this->requestSetAdapterHelper->expectsFromDataToEntitySetRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterFactoryHelper->expectsCreate_Success($this->pdoAdapterMock);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_withoutResults_Success($this->pdoMock, $this->containerName);

        $entities = $this->repository->retrieve($this->criteria);

        $this->assertEquals([], $entities);

    }

    public function testRetrieve_throwsPDOException_internally_throwsEntitySetException() {

        $this->requestSetAdapterHelper->expectsFromDataToEntitySetRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterFactoryHelper->expectsCreate_Success($this->pdoAdapterMock);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_throwsPDOException($this->pdoMock, $this->containerName);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsPDOException_throwsEntitySetException() {

        $this->requestSetAdapterHelper->expectsFromDataToEntitySetRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetch_throwsPDOException($this->request);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsRequestSetException_throwsEntitySetException() {

        $this->requestSetAdapterHelper->expectsFromDataToEntitySetRequest_throwsRequestSetException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withoutContainerInCriteria_throwsEntitySetException() {

        unset($this->criteria['container']);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntitySetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
