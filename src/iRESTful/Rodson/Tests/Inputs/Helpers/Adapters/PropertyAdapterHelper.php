<?php
namespace iRESTful\Rodson\Tests\Inputs\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Exceptions\PropertyException;

final class PropertyAdapterHelper {
    private $phpunit;
    private $propertyAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PropertyAdapter $propertyAdapterMock) {
        $this->phpunit = $phpunit;
        $this->propertyAdapterMock = $propertyAdapterMock;
    }

    public function expectsFromDataToProperties_Success(array $returnedProperties, array $data) {
        $this->propertyAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToProperties')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedProperties));
    }

    public function expectsFromDataToProperties_throwsPropertyException(array $data) {
        $this->propertyAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToProperties')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new PropertyException('TEST')));
    }

}
