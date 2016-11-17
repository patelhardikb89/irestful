<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterAdapterHelper;

final class ConcreteEntityAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $entityRelationRepositoryMock;
    private $entityRepositoryMock;
    private $entityAdapterAdapterMock;
    private $entityAdapterMock;
    private $factory;
    private $entityAdapterAdapterHelper;
    public function setUp() {
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->entityAdapterAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');

        $this->factory = new ConcreteEntityAdapterFactory($this->entityRepositoryMock, $this->entityRelationRepositoryMock, $this->entityAdapterAdapterMock);

        $this->entityAdapterAdapterHelper = new EntityAdapterAdapterHelper($this, $this->entityAdapterAdapterMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->entityAdapterAdapterHelper->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->entityRepositoryMock, $this->entityRelationRepositoryMock);

        $entityAdapter = $this->factory->create();

        $this->assertEquals($this->entityAdapterMock, $entityAdapter);

    }

}
