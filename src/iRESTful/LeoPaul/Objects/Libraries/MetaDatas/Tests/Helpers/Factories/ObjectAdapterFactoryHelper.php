<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\ObjectAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter;

final class ObjectAdapterFactoryHelper {
    private $phpunit;
    private $objectAdapterFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ObjectAdapterFactory $objectAdapterFactoryMock) {
        $this->phpunit = $phpunit;
        $this->objectAdapterFactoryMock = $objectAdapterFactoryMock;
    }

    public function expectsCreate_Success(ObjectAdapter $returnedAdapter) {
        $this->objectAdapterFactoryMock->expects($this->phpunit->once())
                                        ->method('create')
                                        ->will($this->phpunit->returnValue($returnedAdapter));
    }

}
