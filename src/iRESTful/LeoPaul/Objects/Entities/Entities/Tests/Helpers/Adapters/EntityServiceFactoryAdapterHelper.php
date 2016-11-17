<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\Adapters\EntityServiceFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityServiceFactoryAdapterHelper {
    private $phpunit;
    private $entityServiceFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityServiceFactoryAdapter $entityServiceFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityServiceFactoryAdapterMock = $entityServiceFactoryAdapterMock;
    }

    public function expectsFromDataToEntityServiceFactory_Success(EntityServiceFactory $returnedFactory, array $data) {
        $this->entityServiceFactoryAdapterMock->expects($this->phpunit->once())
                                                ->method('fromDataToEntityServiceFactory')
                                                ->with($data)
                                                ->will($this->phpunit->returnValue($returnedFactory));

    }

    public function expectsFromDataToEntityServiceFactory_throwsEntityException(array $data) {
        $this->entityServiceFactoryAdapterMock->expects($this->phpunit->once())
                                                ->method('fromDataToEntityServiceFactory')
                                                ->with($data)
                                                ->will($this->phpunit->throwException(new EntityException('TEST')));

    }

}
