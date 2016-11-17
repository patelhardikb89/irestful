<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetRepositoryHelper {
    private $phpunit;
    private $entityPartialSetRepositoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityPartialSetRepository $entityPartialSetRepositoryMock) {
        $this->phpunit = $phpunit;
        $this->entityPartialSetRepositoryMock = $entityPartialSetRepositoryMock;
    }

    public function expectsRetrieve_Success(EntityPartialSet $returnedEntityPartialSet, array $criteria) {
        $this->entityPartialSetRepositoryMock->expects($this->phpunit->once())
                                                ->method('retrieve')
                                                ->with($criteria)
                                                ->will($this->phpunit->returnValue($returnedEntityPartialSet));
    }

    public function expectsRetrieve_throwsEntityPartialSetException(array $criteria) {
        $this->entityPartialSetRepositoryMock->expects($this->phpunit->once())
                                                ->method('retrieve')
                                                ->with($criteria)
                                                ->will($this->phpunit->throwException(new EntityPartialSetException('TEST')));
    }

}
