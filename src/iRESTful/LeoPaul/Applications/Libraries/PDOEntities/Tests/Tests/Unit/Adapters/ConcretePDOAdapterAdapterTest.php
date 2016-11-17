<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\ConcretePDOAdapterAdapter;

final class ConcretePDOAdapterAdapterTest extends \PHPUnit_Framework_TestCase {
    private $entityAdapterAdapterMock;
    private $entityRepositoryMock;
    private $entityRelationRepositoryMock;
    private $adapterWithRepository;
    private $adapterWithRelationRepository;
    public function setUp() {
        $this->entityAdapterAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter');
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');

        $this->adapterWithRepository = new ConcretePDOAdapterAdapter($this->entityAdapterAdapterMock, $this->entityRepositoryMock);
        $this->adapterWithRelationRepository = new ConcretePDOAdapterAdapter($this->entityAdapterAdapterMock, null, $this->entityRelationRepositoryMock);
    }

    public function tearDown() {

    }

    public function testFromEntityRepositoryToPDOAdapter_Success() {

        $adapter = $this->adapterWithRelationRepository->fromEntityRepositoryToPDOAdapter($this->entityRepositoryMock);

        $this->assertTrue($adapter instanceof \iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter);

    }

    public function testFromEntityRelationRepositoryToPDOAdapter_Success() {

        $adapter = $this->adapterWithRepository->fromEntityRelationRepositoryToPDOAdapter($this->entityRelationRepositoryMock);

        $this->assertTrue($adapter instanceof \iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter);

    }

}
