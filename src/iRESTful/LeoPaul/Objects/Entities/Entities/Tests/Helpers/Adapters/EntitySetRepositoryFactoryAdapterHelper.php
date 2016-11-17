<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\Adapters\EntitySetRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Factories\EntitySetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetRepositoryFactoryAdapterHelper {
    private $phpunit;
    private $entitySetRepositoryFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntitySetRepositoryFactoryAdapter $entitySetRepositoryFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entitySetRepositoryFactoryAdapterMock = $entitySetRepositoryFactoryAdapterMock;
    }

    public function expectsFromDataToEntitySetRepositoryFactory_Success(EntitySetRepositoryFactory $returnedFactory, array $data) {
        $this->entitySetRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                    ->method('fromDataToEntitySetRepositoryFactory')
                                                    ->with($data)
                                                    ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToEntitySetRepositoryFactory_throwsEntitySetException(array $data) {
        $this->entitySetRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                    ->method('fromDataToEntitySetRepositoryFactory')
                                                    ->with($data)
                                                    ->will($this->phpunit->throwException(new EntitySetException('TEST')));
    }

}
