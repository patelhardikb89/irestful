<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\ConcretePDOAdapterFactory;

final class ConcretePDOAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $entityAdapterAdapterMock;
    private $entityRepositoryMock;
    private $entityRelationRepositoryMock;
    private $factory;
    public function setUp() {
        $this->entityAdapterAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter');
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');

        $this->factory = new ConcretePDOAdapterFactory($this->entityAdapterAdapterMock, $this->entityRepositoryMock, $this->entityRelationRepositoryMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $pdoAdapter = $this->factory->create();

        $this->assertTrue($pdoAdapter instanceof \iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter);

    }

}
