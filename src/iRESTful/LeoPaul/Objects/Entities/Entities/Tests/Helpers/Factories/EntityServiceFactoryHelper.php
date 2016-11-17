<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\Factories\EntityServiceFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityServiceFactoryHelper {
    private $phpunit;
    private $entityServiceFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityServiceFactory $entityServiceFactoryMock) {
        $this->phpunit = $phpunit;
        $this->entityServiceFactoryMock = $entityServiceFactoryMock;
    }

    public function expectsCreate_Success(EntityService $returnedService) {
        $this->entityServiceFactoryMock->expects($this->phpunit->once())
                                        ->method('create')
                                        ->will($this->phpunit->returnValue($returnedService));
    }

    public function expectsCreate_throwsEntityException() {
        $this->entityServiceFactoryMock->expects($this->phpunit->once())
                                        ->method('create')
                                        ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

}
