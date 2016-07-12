<?php
namespace iRESTful\Rodson\Tests\Helpers\Objects;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;

final class ObjectHelper {
    private $phpunit;
    private $objectMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Object $objectMock) {
        $this->phpunit = $phpunit;
        $this->objectMock = $objectMock;
    }

    public function expectsGetName_Success($returnedName) {
        $this->objectMock->expects($this->phpunit->once())
                            ->method('getName')
                            ->will($this->phpunit->returnValue($returnedName));
    }

    public function expectsGetName_multiple_Success(array $returnedNames) {
        $amount = count($returnedNames);
        $this->objectMock->expects($this->phpunit->exactly($amount))
                            ->method('getName')
                            ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedNames));
    }

    public function expectsGetProperties_Success(array $returnedProperties) {
        $this->objectMock->expects($this->phpunit->once())
                            ->method('getProperties')
                            ->will($this->phpunit->returnValue($returnedProperties));
    }

    public function expectsGetProperties_multiple_Success(array $returnedProperties) {
        $amount = count($returnedProperties);
        $this->objectMock->expects($this->phpunit->exactly($amount))
                            ->method('getProperties')
                            ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedProperties));
    }

}
