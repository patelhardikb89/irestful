<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\Adapters\EntityRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Factories\EntityRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityRepositoryFactoryAdapterHelper {
    private $phpunit;
    private $entityRepositoryFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityRepositoryFactoryAdapter $entityRepositoryFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityRepositoryFactoryAdapterMock = $entityRepositoryFactoryAdapterMock;
    }

    public function expectsFromDataToEntityRepositoryFactory_Success(EntityRepositoryFactory $returnedFactory, array $data) {
        $this->entityRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                    ->method('fromDataToEntityRepositoryFactory')
                                                    ->with($data)
                                                    ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToEntityRepositoryFactory_throwsEntityException(array $data) {
        $this->entityRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                    ->method('fromDataToEntityRepositoryFactory')
                                                    ->with($data)
                                                    ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

}
