<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityRepositoryFactoryHelper {
    private $phpunit;
    private $entityRepositoryFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityRepositoryFactory $entityRepositoryFactoryMock) {
        $this->phpunit = $phpunit;
        $this->entityRepositoryFactoryMock = $entityRepositoryFactoryMock;
    }

    public function expectsCreate_Success(EntityRepository $returnedRepository) {
        $this->entityRepositoryFactoryMock->expects($this->phpunit->once())
                                            ->method('create')
                                            ->will($this->phpunit->returnValue($returnedRepository));
    }

    public function expectsCreate_throwsEntityException() {
        $this->entityRepositoryFactoryMock->expects($this->phpunit->once())
                                            ->method('create')
                                            ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

}
