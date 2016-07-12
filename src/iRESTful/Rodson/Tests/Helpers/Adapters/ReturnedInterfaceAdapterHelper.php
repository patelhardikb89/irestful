<?php
namespace iRESTful\Rodson\Tests\Helpers\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Returns\Adapters\ReturnedInterfaceAdapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Returns\ReturnedInterface;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Returns\Exceptions\ReturnedInterfaceException;

final class ReturnedInterfaceAdapterHelper {
    private $phpunit;
    private $returnedInterfaceAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ReturnedInterfaceAdapter $returnedInterfaceAdapterMock) {
        $this->phpunit = $phpunit;
        $this->returnedInterfaceAdapterMock = $returnedInterfaceAdapterMock;
    }

    public function expectsFromTypeToReturnedInterface_Success(ReturnedInterface $returnedInterface, Type $type) {
        $this->returnedInterfaceAdapterMock->expects($this->phpunit->once())
                                            ->method('fromTypeToReturnedInterface')
                                            ->with($type)
                                            ->will($this->phpunit->returnValue($returnedInterface));
    }

    public function expectsFromTypeToReturnedInterface_throwsReturnedInterfaceException(Type $type) {
        $this->returnedInterfaceAdapterMock->expects($this->phpunit->once())
                                            ->method('fromTypeToReturnedInterface')
                                            ->with($type)
                                            ->will($this->phpunit->throwException(new ReturnedInterfaceException('TEST')));
    }

    public function expectsfromPropertyTypeToReturnedInterface_Success(ReturnedInterface $returnedInterface, PropertyType $propertyType) {
        $this->returnedInterfaceAdapterMock->expects($this->phpunit->once())
                                            ->method('fromPropertyTypeToReturnedInterface')
                                            ->with($propertyType)
                                            ->will($this->phpunit->returnValue($returnedInterface));
    }

    public function expectsfromPropertyTypeToReturnedInterface_throwsReturnedInterfaceException(PropertyType $propertyType) {
        $this->returnedInterfaceAdapterMock->expects($this->phpunit->once())
                                            ->method('fromPropertyTypeToReturnedInterface')
                                            ->with($propertyType)
                                            ->will($this->phpunit->throwException(new ReturnedInterfaceException('TEST')));
    }

}
