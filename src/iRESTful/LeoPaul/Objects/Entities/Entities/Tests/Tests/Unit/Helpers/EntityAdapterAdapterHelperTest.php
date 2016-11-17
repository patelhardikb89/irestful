<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters\EntityAdapterAdapterHelper;

final class EntityAdapterAdapterHelperTest extends \PHPUnit_Framework_TestCase {
    private $entityAdapterAdapterMock;
    private $entityAdapterMock;
    private $entityRepositoryMock;
    private $entityRelationRepositoryMock;
    private $helper;
    public function setUp() {
        $this->entityAdapterAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter');
        $this->entityAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter');
        $this->entityRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository');
        $this->entityRelationRepositoryMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository');

        $this->helper = new EntityAdapterAdapterHelper($this, $this->entityAdapterAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromRepositoriesToEntityAdapter_Success() {

        $this->helper->expectsFromRepositoriesToEntityAdapter_Success($this->entityAdapterMock, $this->entityRepositoryMock, $this->entityRelationRepositoryMock);

        $entityAdapter = $this->entityAdapterAdapterMock->fromRepositoriesToEntityAdapter($this->entityRepositoryMock, $this->entityRelationRepositoryMock);

        $this->assertEquals($this->entityAdapterMock, $entityAdapter);

    }

}
