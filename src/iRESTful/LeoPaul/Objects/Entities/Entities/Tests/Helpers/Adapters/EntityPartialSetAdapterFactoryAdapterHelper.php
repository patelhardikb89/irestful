<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\Adapters\EntityPartialSetAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\EntityPartialSetAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class EntityPartialSetAdapterFactoryAdapterHelper {
    private $phpunit;
    private $entityPartialSetAdapterFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityPartialSetAdapterFactoryAdapter $entityPartialSetAdapterFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityPartialSetAdapterFactoryAdapterMock = $entityPartialSetAdapterFactoryAdapterMock;
    }

    public function expectsFromDataToEntityPartialSetAdapterFactory_Success(EntityPartialSetAdapterFactory $returnedFactory, array $data) {
        $this->entityPartialSetAdapterFactoryAdapterMock->expects($this->phpunit->once())
                                                        ->method('fromDataToEntityPartialSetAdapterFactory')
                                                        ->with($data)
                                                        ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToEntityPartialSetAdapterFactory_throwsEntityPartialSetException(array $data) {
        $this->entityPartialSetAdapterFactoryAdapterMock->expects($this->phpunit->once())
                                                        ->method('fromDataToEntityPartialSetAdapterFactory')
                                                        ->with($data)
                                                        ->will($this->phpunit->throwException(new EntityPartialSetException('TEST')));
    }

}
