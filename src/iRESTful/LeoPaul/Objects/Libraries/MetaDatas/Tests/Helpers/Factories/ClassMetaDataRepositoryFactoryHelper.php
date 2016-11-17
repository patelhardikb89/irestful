<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\Factories\ClassMetaDataRepositoryFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository;

final class ClassMetaDataRepositoryFactoryHelper {
    private $phpunit;
    private $classMetaDataRepositoryFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ClassMetaDataRepositoryFactory $classMetaDataRepositoryFactoryMock) {
        $this->phpunit = $phpunit;
        $this->classMetaDataRepositoryFactoryMock = $classMetaDataRepositoryFactoryMock;
    }

    public function expectsCreate_Success(ClassMetaDataRepository $returnedRepository) {
        $this->classMetaDataRepositoryFactoryMock->expects($this->phpunit->once())
                                                    ->method('create')
                                                    ->will($this->phpunit->returnValue($returnedRepository));
    }

}
