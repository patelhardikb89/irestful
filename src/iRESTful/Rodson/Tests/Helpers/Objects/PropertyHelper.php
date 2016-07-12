<?php
namespace iRESTful\Rodson\Tests\Helpers\Objects;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type;

final class PropertyHelper {
    private $phpunit;
    private $propertyMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Property $propertyMock) {
        $this->phpunit = $phpunit;
        $this->propertyMock = $propertyMock;
    }

    public function expectsGetName_Success($returnedName) {
        $this->propertyMock->expects($this->phpunit->once())
                            ->method('getName')
                            ->will($this->phpunit->returnValue($returnedName));
    }

    public function expectsGetType_Success(Type $returnedType) {
        $this->propertyMock->expects($this->phpunit->once())
                            ->method('getType')
                            ->will($this->phpunit->returnValue($returnedType));
    }

    public function expectsGetType_multiple_Success(array $returnedTypes) {
        $amount = count($returnedTypes);
        $this->propertyMock->expects($this->phpunit->exactly($amount))
                            ->method('getType')
                            ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedTypes));
    }

}
