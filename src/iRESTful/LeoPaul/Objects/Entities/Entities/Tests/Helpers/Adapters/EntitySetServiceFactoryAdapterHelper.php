<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\Adapters\EntitySetServiceFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetServiceFactoryAdapterHelper {
    private $phpunit;
    private $entitySetServiceFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntitySetServiceFactoryAdapter $entitySetServiceFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entitySetServiceFactoryAdapterMock = $entitySetServiceFactoryAdapterMock;
    }

    public function expectsFromDataToEntitySetServiceFactory_Success(EntitySetServiceFactory $returnedFactory, array $data) {
        $this->entitySetServiceFactoryAdapterMock->expects($this->phpunit->once())
                                                    ->method('fromDataToEntitySetServiceFactory')
                                                    ->with($data)
                                                    ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToEntitySetServiceFactory_throwsEntitySetException(array $data) {
        $this->entitySetServiceFactoryAdapterMock->expects($this->phpunit->once())
                                                    ->method('fromDataToEntitySetServiceFactory')
                                                    ->with($data)
                                                    ->will($this->phpunit->throwException(new EntitySetException('TEST')));
    }

}
