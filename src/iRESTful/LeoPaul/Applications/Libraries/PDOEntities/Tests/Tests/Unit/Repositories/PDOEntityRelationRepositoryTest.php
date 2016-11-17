<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories\PDOEntityRelationRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Repositories\PDORepositoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\PDOAdapterAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\PDOAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\RequestRelationAdapterHelper;

final class PDOEntityRelationRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $requestRelationAdapterMock;
    private $pdoRepositoryMock;
    private $pdoAdapterAdapterMock;
    private $pdoAdapterMock;
    private $pdoMock;
    private $entityMock;
    private $containerName;
    private $slaveContainerName;
    private $criteria;
    private $query;
    private $request;
    private $entities;
    private $repository;
    private $requestRelationAdapterHelper;
    private $pdoRepositoryHelper;
    private $pdoAdapterAdapterHelper;
    private $pdoAdapterHelper;
    public function setUp() {
        $this->requestRelationAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Adapters\RequestRelationAdapter');
        $this->pdoRepositoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository');
        $this->pdoAdapterAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Adapters\PDOAdapterAdapter');
        $this->pdoAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter');
        $this->pdoMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->containerName = 'roles';
        $this->slaveContainerName = 'permissions';

        $this->criteria = [
            'master_container' => $this->containerName,
            'slave_container' => $this->slaveContainerName,
            'slave_property' => 'permission',
            'master_uuid' => '8cb42898-1856-4d90-ad8b-a2f159aa2187'
        ];

        $this->request = [
            'query' => $this->query,
            'params' => [
                $this->slaveContainerName => hex2bin(str_replace('-', '', '8cb42898-1856-4d90-ad8b-a2f159aa2187'))
            ]
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->repository = new PDOEntityRelationRepository($this->requestRelationAdapterMock, $this->pdoRepositoryMock, $this->pdoAdapterAdapterMock);

        $this->requestRelationAdapterHelper = new RequestRelationAdapterHelper($this, $this->requestRelationAdapterMock);
        $this->pdoRepositoryHelper = new PDORepositoryHelper($this, $this->pdoRepositoryMock);
        $this->pdoAdapterAdapterHelper = new PDOAdapterAdapterHelper($this, $this->pdoAdapterAdapterMock);
        $this->pdoAdapterHelper = new PDOAdapterHelper($this, $this->pdoAdapterMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->pdoAdapterAdapterHelper->expectsFromEntityRelationRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_Success($this->entities, $this->pdoMock, $this->slaveContainerName);

        $entities = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entities, $entities);


    }

    public function testRetrieve_withoutResults_Success() {

        $this->pdoAdapterAdapterHelper->expectsFromEntityRelationRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_withoutResults_Success($this->pdoMock, $this->slaveContainerName);

        $entities = $this->repository->retrieve($this->criteria);

        $this->assertEquals([], $entities);


    }

    public function testRetrieve_throwsPDOException_internally_throwsEntityRelationException() {

        $this->pdoAdapterAdapterHelper->expectsFromEntityRelationRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetch_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntities_throwsPDOException($this->pdoMock, $this->slaveContainerName);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsPDOException_throwsEntityRelationException() {

        $this->pdoAdapterAdapterHelper->expectsFromEntityRelationRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetch_throwsPDOException($this->request);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsRequestRelationException_throwsEntityRelationException() {

        $this->pdoAdapterAdapterHelper->expectsFromEntityRelationRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestRelationAdapterHelper->expectsFromDataToEntityRelationRequest_throwsRequestRelationException($this->criteria);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withoutSlaveContainerInCriteria_throwsEntityRelationException() {

        unset($this->criteria['slave_container']);

        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityRelationException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
