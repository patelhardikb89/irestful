<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\Adapters\EntityPartialSetRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Factories\EntityPartialSetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetRepositoryFactoryAdapterHelper {
    private $phpunit;
    private $entityPartialSetRepositoryFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityPartialSetRepositoryFactoryAdapter $entityPartialSetRepositoryFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityPartialSetRepositoryFactoryAdapterMock = $entityPartialSetRepositoryFactoryAdapterMock;
    }

    public function expectsFromDataToEntityPartialSetRepositoryFactory_Success(EntityPartialSetRepositoryFactory $returnedFactory, array $data) {
        $this->entityPartialSetRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                            ->method('fromDataToEntityPartialSetRepositoryFactory')
                                                            ->with($data)
                                                            ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToEntityPartialSetRepositoryFactory_throwsEntityPartialSetException(array $data) {
        $this->entityPartialSetRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                            ->method('fromDataToEntityPartialSetRepositoryFactory')
                                                            ->with($data)
                                                            ->will($this->phpunit->throwException(new EntityPartialSetException('TEST')));
    }

}
