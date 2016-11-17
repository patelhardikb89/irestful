<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\Factories\EntitySetServiceFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Services\EntitySetService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;

final class EntitySetServiceFactoryHelper {
    private $phpunit;
    private $entitySetServiceFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntitySetServiceFactory $entitySetServiceFactoryMock) {
        $this->phpunit = $phpunit;
        $this->entitySetServiceFactoryMock = $entitySetServiceFactoryMock;
    }

    public function expectsCreate_Success(EntitySetService $returnedService) {
        $this->entitySetServiceFactoryMock->expects($this->phpunit->once())
                                            ->method('create')
                                            ->will($this->phpunit->returnValue($returnedService));

    }

    public function expectsCreate_throwsEntitySetException() {
        $this->entitySetServiceFactoryMock->expects($this->phpunit->once())
                                            ->method('create')
                                            ->will($this->phpunit->throwException(new EntitySetException('TEST')));

    }

}
