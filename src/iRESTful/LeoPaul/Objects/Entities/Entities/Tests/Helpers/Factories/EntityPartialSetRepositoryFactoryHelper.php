<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetRepositoryFactoryHelper {
    private $phpunit;
    private $entityPartialSetRepositoryFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityPartialSetRepositoryFactory $entityPartialSetRepositoryFactoryMock) {
        $this->phpunit = $phpunit;
        $this->entityPartialSetRepositoryFactoryMock = $entityPartialSetRepositoryFactoryMock;
    }

    public function expectsCreate_Success(EntityPartialSetRepository $returnedRepository) {
        $this->entityPartialSetRepositoryFactoryMock->expects($this->phpunit->once())
                                                    ->method('create')
                                                    ->will($this->phpunit->returnValue($returnedRepository));
    }

    public function expectsCreate_throwsEntityPartialSetException() {
        $this->entityPartialSetRepositoryFactoryMock->expects($this->phpunit->once())
                                                    ->method('create')
                                                    ->will($this->phpunit->throwException(new EntityPartialSetException('TEST')));
    }

}
