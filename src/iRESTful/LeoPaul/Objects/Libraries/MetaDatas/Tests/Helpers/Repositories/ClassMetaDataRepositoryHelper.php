<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Repositories;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;

final class ClassMetaDataRepositoryHelper {
    private $phpunit;
    private $classMetaDataRepositoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ClassMetaDataRepository $classMetaDataRepositoryMock) {
        $this->phpunit = $phpunit;
        $this->classMetaDataRepositoryMock = $classMetaDataRepositoryMock;
    }

    public function expectsRetrieve_Success(ClassMetaData $returnedClassMetaData, array $criteria) {
        $this->classMetaDataRepositoryMock->expects($this->phpunit->once())
                                            ->method('retrieve')
                                            ->with($criteria)
                                            ->will($this->phpunit->returnValue($returnedClassMetaData));
    }

    public function expectsRetrieve_throwsClassMetaDataException(array $criteria) {
        $this->classMetaDataRepositoryMock->expects($this->phpunit->once())
                                            ->method('retrieve')
                                            ->with($criteria)
                                            ->will($this->phpunit->throwException(new ClassMetaDataException('TEST')));
    }

}
