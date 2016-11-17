<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\Factories\Adapters\ClassMetaDataRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\Factories\ClassMetaDataRepositoryFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ClassMetaDataRepositoryFactoryAdapterHelper {
    private $phpunit;
    private $classMetaDataRepositoryFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ClassMetaDataRepositoryFactoryAdapter $classMetaDataRepositoryFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->classMetaDataRepositoryFactoryAdapterMock = $classMetaDataRepositoryFactoryAdapterMock;
    }

    public function expectsFromDataToClassMetaDataRepositoryFactory_Success(ClassMetaDataRepositoryFactory $returnedFactory, array $data) {
        $this->classMetaDataRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                        ->method('fromDataToClassMetaDataRepositoryFactory')
                                                        ->with($data)
                                                        ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToClassMetaDataRepositoryFactory_throwsClassMetaDataException(array $data) {
        $this->classMetaDataRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                        ->method('fromDataToClassMetaDataRepositoryFactory')
                                                        ->with($data)
                                                        ->will($this->phpunit->throwException(new ClassMetaDataException('TEST')));
    }

}
