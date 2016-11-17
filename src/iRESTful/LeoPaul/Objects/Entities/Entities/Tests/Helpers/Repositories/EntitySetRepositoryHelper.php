<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\EntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetRepositoryHelper {
    private $phpunit;
    private $entitySetRepositoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntitySetRepository $entitySetRepositoryMock) {
        $this->phpunit = $phpunit;
        $this->entitySetRepositoryMock = $entitySetRepositoryMock;
    }

    public function expectsRetrieve_Success(array $returnedEntities, array $criteria) {
        $this->entitySetRepositoryMock->expects($this->phpunit->once())
                                        ->method('retrieve')
                                        ->with($criteria)
                                        ->will($this->phpunit->returnValue($returnedEntities));
    }

    public function expectsRetrieve_throwsEntitySetException(array $criteria) {
        $this->entitySetRepositoryMock->expects($this->phpunit->once())
                                        ->method('retrieve')
                                        ->with($criteria)
                                        ->will($this->phpunit->throwException(new EntitySetException('TEST')));
    }

}
