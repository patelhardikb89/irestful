<?php
namespace iRESTful\Rodson\Tests\Helpers\Objects;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;

final class PropertyTypeHelper {
    private $phpunit;
    private $typeMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PropertyType $typeMock) {
        $this->phpunit = $phpunit;
        $this->typeMock = $typeMock;
    }

    public function expectsHasType_Success($returnedBoolean) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('hasType')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsHasType_multiple_Success(array $returnedBooleans) {
        $amount = count($returnedBooleans);
        $this->typeMock->expects($this->phpunit->exactly($amount))
                        ->method('hasType')
                        ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedBooleans));
    }

    public function expectsGetType_Success(Type $returnedType) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('getType')
                        ->will($this->phpunit->returnValue($returnedType));
    }

    public function expectsHasObject_Success($returnedBoolean) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('hasObject')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetObject_Success(Object $returnedObject) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('getObject')
                        ->will($this->phpunit->returnValue($returnedObject));
    }

}
