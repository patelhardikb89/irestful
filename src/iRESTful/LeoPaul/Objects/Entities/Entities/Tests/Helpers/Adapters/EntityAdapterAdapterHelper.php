<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;

final class EntityAdapterAdapterHelper {
    private $phpunit;
    private $entityAdapterAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityAdapterAdapter $entityAdapterAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityAdapterAdapterMock = $entityAdapterAdapterMock;
    }

    public function expectsFromRepositoriesToEntityAdapter_Success(EntityAdapter $returnedEntityAdapter, EntityRepository $entityRepository, EntityRelationRepository $entityRelationRepository) {
        $this->entityAdapterAdapterMock->expects($this->phpunit->once())
                                        ->method('fromRepositoriesToEntityAdapter')
                                        ->with($entityRepository, $entityRelationRepository)
                                        ->will($this->phpunit->returnValue($returnedEntityAdapter));
    }

}
