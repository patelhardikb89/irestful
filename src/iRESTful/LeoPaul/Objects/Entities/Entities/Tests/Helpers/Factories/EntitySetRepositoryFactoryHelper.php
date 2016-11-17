<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\EntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetRepositoryFactoryHelper {
    private $phpunit;
    private $entitySetRepositoryFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntitySetRepositoryFactory $entitySetRepositoryFactoryMock) {
        $this->phpunit = $phpunit;
        $this->entitySetRepositoryFactoryMock = $entitySetRepositoryFactoryMock;
    }

    public function expectsCreate_Success(EntitySetRepository $returnedRepository) {
        $this->entitySetRepositoryFactoryMock->expects($this->phpunit->once())
                                                ->method('create')
                                                ->will($this->phpunit->returnValue($returnedRepository));
    }

    public function expectsCreate_throwsEntitySetException() {
        $this->entitySetRepositoryFactoryMock->expects($this->phpunit->once())
                                                ->method('create')
                                                ->will($this->phpunit->throwException(new EntitySetException('TEST')));
    }

}
