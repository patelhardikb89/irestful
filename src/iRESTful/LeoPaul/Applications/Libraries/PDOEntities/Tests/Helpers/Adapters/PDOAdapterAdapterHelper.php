<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Adapters\PDOAdapterAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;

final class PDOAdapterAdapterHelper {
    private $phpunit;
    private $pdoAdapterAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDOAdapterAdapter $pdoAdapterAdapterMock) {
        $this->phpunit = $phpunit;
        $this->pdoAdapterAdapterMock = $pdoAdapterAdapterMock;
    }

    public function expectsFromEntityRepositoryToPDOAdapter_Success(PDOAdapter $returnedPDOAdapter, EntityRepository $repository) {
        $this->pdoAdapterAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntityRepositoryToPDOAdapter')
                                        ->with($repository)
                                        ->will($this->phpunit->returnValue($returnedPDOAdapter));
    }

    public function expectsFromEntityRelationRepositoryToPDOAdapter_Success(PDOAdapter $returnedPDOAdapter, EntityRelationRepository $entityRelationRepository) {
        $this->pdoAdapterAdapterMock->expects($this->phpunit->once())
                                        ->method('fromEntityRelationRepositoryToPDOAdapter')
                                        ->with($entityRelationRepository)
                                        ->will($this->phpunit->returnValue($returnedPDOAdapter));
    }

}
