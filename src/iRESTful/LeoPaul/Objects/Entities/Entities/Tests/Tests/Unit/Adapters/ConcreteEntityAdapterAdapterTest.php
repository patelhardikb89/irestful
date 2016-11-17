<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters\ConcreteEntityAdapterAdapter;

final class ConcreteEntityAdapterAdapterTest extends \PHPUnit_Framework_TestCase {
    private $objectAdapterMock;
    private $classMetaDataRepositoryMock;
    private $entityRepositoryMock;
    private $entityRelationRepositoryMock;
    private $adapter;
    private $entityAdapter;
    public function setUp() {
        $this->objectAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter');
        $this->classMetaDataRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository');
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');

        $this->adapter = new ConcreteEntityAdapterAdapter($this->objectAdapterMock, $this->classMetaDataRepositoryMock);
        $this->entityAdapter = new ConcreteEntityAdapter($this->entityRepositoryMock, $this->entityRelationRepositoryMock, $this->objectAdapterMock, $this->classMetaDataRepositoryMock);
    }

    public function tearDown() {

    }

    public function testFromRepositoriesToEntityAdapter_Success() {

        $entityAdapter = $this->adapter->fromRepositoriesToEntityAdapter($this->entityRepositoryMock, $this->entityRelationRepositoryMock);

        $this->assertEquals($this->entityAdapter, $entityAdapter);
    }

}
