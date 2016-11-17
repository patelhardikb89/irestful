<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\Factories\SubEntitySetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\SubEntitySetRepository;

final class SubEntitySetRepositoryFactoryHelper {
    private $phpunit;
    private $subEntitySetRepositoryFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, SubEntitySetRepositoryFactory $subEntitySetRepositoryFactoryMock) {
        $this->phpunit = $phpunit;
        $this->subEntitySetRepositoryFactoryMock = $subEntitySetRepositoryFactoryMock;
    }

    public function expectsCreate_Success(SubEntitySetRepository $returnedRepository) {
        $this->subEntitySetRepositoryFactoryMock->expects($this->phpunit->once())
                                                ->method('create')
                                                ->will($this->phpunit->returnValue($returnedRepository));
    }

}
