<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\Adapters\ObjectAdapterFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\Factories\ObjectAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;

final class ObjectAdapterFactoryAdapterHelper {
    private $phpunit;
    private $objectAdapterFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ObjectAdapterFactoryAdapter $objectAdapterFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->objectAdapterFactoryAdapterMock = $objectAdapterFactoryAdapterMock;
    }

    public function expectsFromDataToObjectAdapterFactory_Success(ObjectAdapterFactory $returnedFactory, array $data) {
        $this->objectAdapterFactoryAdapterMock->expects($this->phpunit->once())
                                                ->method('fromDataToObjectAdapterFactory')
                                                ->with($data)
                                                ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToObjectAdapterFactory_throwsObjectException(array $data) {
        $this->objectAdapterFactoryAdapterMock->expects($this->phpunit->once())
                                                ->method('fromDataToObjectAdapterFactory')
                                                ->with($data)
                                                ->will($this->phpunit->throwException(new ObjectException('TEST')));
    }

}
