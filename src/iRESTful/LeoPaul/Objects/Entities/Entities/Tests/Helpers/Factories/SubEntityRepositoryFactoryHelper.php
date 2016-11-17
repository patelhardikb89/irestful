<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories\Factories\SubEntityRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\SubEntitySetRepository;

final class SubEntityRepositoryFactoryHelper {
    private $phpunit;
    private $subEntityRepositoryFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, SubEntityRepositoryFactory $subEntityRepositoryFactoryMock) {
        $this->phpunit = $phpunit;
        $this->subEntityRepositoryFactoryMock = $subEntityRepositoryFactoryMock;
    }

    public function expectsCreate_Success(SubEntitySetRepository $returnedRepository) {
        $this->subEntityRepositoryFactoryMock->expects($this->phpunit->once())
                                                ->method('create')
                                                ->will($this->phpunit->returnValue($returnedRepository));
    }

}
