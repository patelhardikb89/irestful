<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\Factories\EntityPartialSetAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter;

final class EntityPartialSetAdapterFactoryHelper {
    private $phpunit;
    private $entityPartialSetAdapterFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityPartialSetAdapterFactory $entityPartialSetAdapterFactoryMock) {
        $this->phpunit = $phpunit;
        $this->entityPartialSetAdapterFactoryMock = $entityPartialSetAdapterFactoryMock;
    }

    public function expectsCreate_Success(EntityPartialSetAdapter $returnedAdapter) {
        $this->entityPartialSetAdapterFactoryMock->expects($this->phpunit->once())
                                                ->method('create')
                                                ->will($this->phpunit->returnValue($returnedAdapter));
    }

}
