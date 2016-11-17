<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Factories\EntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class EntityAdapterFactoryHelper {
    private $phpunit;
    private $entityAdapterFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityAdapterFactory $entityAdapterFactoryMock) {
        $this->phpunit = $phpunit;
        $this->entityAdapterFactoryMock = $entityAdapterFactoryMock;
    }

    public function expectsCreate_Success(EntityAdapter $returnedEntityAdapter) {
        $this->entityAdapterFactoryMock->expects($this->phpunit->once())
                                        ->method('create')
                                        ->will($this->phpunit->returnValue($returnedEntityAdapter));
    }

    public function expectsCreate_throwsEntityException() {
        $this->entityAdapterFactoryMock->expects($this->phpunit->once())
                                        ->method('create')
                                        ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

}
