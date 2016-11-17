<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcretePDOAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterAdapterHelper;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Objects\PDOHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Objects\MicroDateTimeClosureHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Exceptions\PDOException;

final class ConcretePDOAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRepositoryMock;
    private $entityRepositoryMock;
    private $entityAdapterAdapterMock;
    private $entityAdapterMock;
    private $entityMock;
    private $pdoMock;
    private $microDateTimeClosureMock;
    private $container;
    private $uuid;
    private $results;
    private $multipleResults;
    private $output;
    private $outputs;
    private $entities;
    private $adapter;
    private $entityAdapterAdapterHelper;
    private $entityAdapterHelper;
    private $pdoHelper;
    private $microDateTimeClosureHelper;
    public function setUp() {
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->entityAdapterAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->pdoMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO');
        $this->microDateTimeClosureMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure');
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');

        $this->container = 'my_container';
        $this->uuid = '2819b42f-efd3-4a9a-a73f-4705bbf3ac1b';

        $this->results = [
            'uuid' => str_replace('-', '', $this->uuid),
            'title' => 'My Title'
        ];

        $this->multipleResults = [
            $this->results,
            $this->results
        ];

        $this->output = [
            'container' => $this->container,
            'data' => $this->results
        ];

        $this->outputs = [
            [
                'container' => $this->container,
                'data' => $this->results
            ],
            [
                'container' => $this->container,
                'data' => $this->results
            ]
        ];

        $this->entities = [
            $this->entityMock,
            $this->entityMock
        ];

        $this->entityAdapterAdapterHelper = new EntityAdapterAdapterHelper($this, $this->entityAdapterAdapterMock);
        $this->entityAdapterHelper = new EntityAdapterHelper($this, $this->entityAdapterMock);
        $this->pdoHelper = new PDOHelper($this, $this->pdoMock);
        $this->microDateTimeClosureHelper = new MicroDateTimeClosureHelper($this, $this->microDateTimeClosureMock);

        $this->adapter = new ConcretePDOAdapter($this->entityAdapterAdapterMock, $this->entityRepositoryMock, $this->entityRelationRepositoryMock);
    }

    public function tearDown() {

    }

    public function testFromPDOToEntity_Success() {

        $this->entityAdapterAdapterHelper ->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->entityRepositoryMock, $this->entityRelationRepositoryMock);
        $this->pdoHelper->expectsGetMicroDateTimeClosure_Success($this->microDateTimeClosureMock);
        $this->microDateTimeClosureHelper->expectsHasResults_Success(true);
        $this->microDateTimeClosureHelper->expectsGetResults_Success($this->results);
        $this->entityAdapterHelper->expectsFromDataToEntity_Success($this->entityMock, $this->output);

        $entity = $this->adapter->fromPDOToEntity($this->pdoMock, $this->container);

        $this->assertEquals($this->entityMock, $entity);

    }

    public function testFromPDOToEntity_withoutResults_Success() {

        $this->entityAdapterAdapterHelper ->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->entityRepositoryMock, $this->entityRelationRepositoryMock);
        $this->pdoHelper->expectsGetMicroDateTimeClosure_Success($this->microDateTimeClosureMock);
        $this->microDateTimeClosureHelper->expectsHasResults_Success(false);

        $entity = $this->adapter->fromPDOToEntity($this->pdoMock, $this->container);

        $this->assertNull($entity);

    }

    public function testFromPDOToEntity_throwsEntityException_throwsPDOException() {

        $this->entityAdapterAdapterHelper ->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->entityRepositoryMock, $this->entityRelationRepositoryMock);
        $this->pdoHelper->expectsGetMicroDateTimeClosure_Success($this->microDateTimeClosureMock);
        $this->microDateTimeClosureHelper->expectsHasResults_Success(true);
        $this->microDateTimeClosureHelper->expectsGetResults_Success($this->results);
        $this->entityAdapterHelper->expectsFromDataToEntity_throwsEntityException($this->output);

        $asserted = false;
        try {

            $this->adapter->fromPDOToEntity($this->pdoMock, $this->container);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromPDOToEntities_Success() {

        $this->entityAdapterAdapterHelper ->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->entityRepositoryMock, $this->entityRelationRepositoryMock);
        $this->pdoHelper->expectsGetMicroDateTimeClosure_Success($this->microDateTimeClosureMock);
        $this->microDateTimeClosureHelper->expectsHasResults_Success(true);
        $this->microDateTimeClosureHelper->expectsGetResults_Success($this->multipleResults);
        $this->entityAdapterHelper->expectsFromDataToEntities_Success($this->entities, $this->outputs);

        $entities = $this->adapter->fromPDOToEntities($this->pdoMock, $this->container);

        $this->assertEquals($this->entities, $entities);

    }

    public function testFromPDOToEntities_withoutResults_Success() {

        $this->entityAdapterAdapterHelper ->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->entityRepositoryMock, $this->entityRelationRepositoryMock);
        $this->pdoHelper->expectsGetMicroDateTimeClosure_Success($this->microDateTimeClosureMock);
        $this->microDateTimeClosureHelper->expectsHasResults_Success(false);

        $entities = $this->adapter->fromPDOToEntities($this->pdoMock, $this->container);

        $this->assertNull($entities);

    }

    public function testFromPDOToEntities_throwsEntityException_throwsPDOException() {

        $this->entityAdapterAdapterHelper ->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->entityRepositoryMock, $this->entityRelationRepositoryMock);
        $this->pdoHelper->expectsGetMicroDateTimeClosure_Success($this->microDateTimeClosureMock);
        $this->microDateTimeClosureHelper->expectsHasResults_Success(true);
        $this->microDateTimeClosureHelper->expectsGetResults_Success($this->multipleResults);
        $this->entityAdapterHelper->expectsFromDataToEntities_throwsEntityException($this->outputs);

        $asserted = false;
        try {

            $this->adapter->fromPDOToEntities($this->pdoMock, $this->container);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
