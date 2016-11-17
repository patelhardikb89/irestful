<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Repositories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Repositories\PDOEntityRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Repositories\PDORepositoryHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\RequestAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\PDOAdapterAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters\PDOAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class PDOEntityRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $pdoRepositoryMock;
    private $requestAdapterMock;
    private $pdoAdapterAdapterMock;
    private $pdoAdapterMock;
    private $pdoMock;
    private $entityMock;
    private $uuid;
    private $containerName;
    private $criteria;
    private $request;
    private $repository;
    private $pdoRepositoryHelper;
    private $requestAdapterHelper;
    private $pdoAdapterAdapterHelper;
    private $pdoAdapterHelper;
    public function setUp() {
        $this->pdoRepositoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository');
        $this->requestAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Adapters\RequestAdapter');
        $this->pdoAdapterAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Adapters\PDOAdapterAdapter');
        $this->pdoAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter');
        $this->pdoMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->uuid = '2819b42f-efd3-4a9a-a73f-4705bbf3ac1b';
        $this->containerName = 'my_container';

        $this->criteria = [
            'container' => $this->containerName,
            'uuid' => $this->uuid
        ];

        $this->request = [
            'query' => 'select * from '.$this->containerName.' where uuid = :uuid limit 0,1;',
            'params' => ['uuid' => str_replace('-', '', $this->uuid)]
        ];

        $this->repository = new PDOEntityRepository($this->pdoRepositoryMock, $this->requestAdapterMock);

        $this->pdoRepositoryHelper = new PDORepositoryHelper($this, $this->pdoRepositoryMock);
        $this->requestAdapterHelper = new RequestAdapterHelper($this, $this->requestAdapterMock);
        $this->pdoAdapterAdapterHelper = new PDOAdapterAdapterHelper($this, $this->pdoAdapterAdapterMock);
        $this->pdoAdapterHelper = new PDOAdapterHelper($this, $this->pdoAdapterMock);
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $this->pdoAdapterAdapterHelper ->expectsFromEntityRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestAdapterHelper->expectsFromDataToEntityRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntity_Success($this->entityMock, $this->pdoMock, $this->containerName);

        $this->repository->addPDOAdapterAdapter($this->pdoAdapterAdapterMock);
        $entity = $this->repository->retrieve($this->criteria);

        $this->assertEquals($this->entityMock, $entity);

    }

    public function testRetrieve_withoutResults_Success() {

        $this->pdoAdapterAdapterHelper ->expectsFromEntityRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestAdapterHelper->expectsFromDataToEntityRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntity_withoutResults_Success($this->pdoMock, $this->containerName);

        $this->repository->addPDOAdapterAdapter($this->pdoAdapterAdapterMock);
        $entity = $this->repository->retrieve($this->criteria);

        $this->assertNull($entity);

    }

    public function testRetrieve_withoutAddingPDOAdapterAdapter_throwsEntityException() {
        
        $asserted = false;
        try {

            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsPDOException_internally_throwsEntityException() {

        $this->pdoAdapterAdapterHelper ->expectsFromEntityRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestAdapterHelper->expectsFromDataToEntityRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntity_throwsPDOException($this->pdoMock, $this->containerName);

        $asserted = false;
        try {

            $this->repository->addPDOAdapterAdapter($this->pdoAdapterAdapterMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsPDOException_throwsEntityException() {

        $this->pdoAdapterAdapterHelper ->expectsFromEntityRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestAdapterHelper->expectsFromDataToEntityRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetchFirst_throwsPDOException($this->request, $this->containerName);

        $asserted = false;
        try {

            $this->repository->addPDOAdapterAdapter($this->pdoAdapterAdapterMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_throwsRequestException_throwsEntityException() {

        $this->pdoAdapterAdapterHelper ->expectsFromEntityRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestAdapterHelper->expectsFromDataToEntityRequest_throwsRequestException($this->criteria);

        $asserted = false;
        try {

            $this->repository->addPDOAdapterAdapter($this->pdoAdapterAdapterMock);
            $this->repository->retrieve($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExists_Success() {

        $this->pdoAdapterAdapterHelper ->expectsFromEntityRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestAdapterHelper->expectsFromDataToEntityRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntity_Success($this->entityMock, $this->pdoMock, $this->containerName);

        $this->repository->addPDOAdapterAdapter($this->pdoAdapterAdapterMock);
        $exists = $this->repository->exists($this->criteria);

        $this->assertTrue($exists);

    }

    public function testExists_doNotExists_Success() {

        $this->pdoAdapterAdapterHelper ->expectsFromEntityRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestAdapterHelper->expectsFromDataToEntityRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntity_withoutResults_Success($this->pdoMock, $this->containerName);

        $this->repository->addPDOAdapterAdapter($this->pdoAdapterAdapterMock);
        $exists = $this->repository->exists($this->criteria);

        $this->assertFalse($exists);

    }

    public function testExists_throwsPDOException_throwsEntityException() {

        $this->pdoAdapterAdapterHelper ->expectsFromEntityRepositoryToPDOAdapter_Success($this->pdoAdapterMock, $this->repository);
        $this->requestAdapterHelper->expectsFromDataToEntityRequest_Success($this->request, $this->criteria);
        $this->pdoRepositoryHelper->expectsFetchFirst_Success($this->pdoMock, $this->request);
        $this->pdoAdapterHelper->expectsFromPDOToEntity_throwsPDOException($this->pdoMock, $this->containerName);

        $asserted = false;
        try {

            $this->repository->addPDOAdapterAdapter($this->pdoAdapterAdapterMock);
            $this->repository->exists($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testExists_withoutContainerInCriteria_throwsEntityException() {

        unset($this->criteria['container']);

        $asserted = false;
        try {

            $this->repository->addPDOAdapterAdapter($this->pdoAdapterAdapterMock);
            $this->repository->exists($this->criteria);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
