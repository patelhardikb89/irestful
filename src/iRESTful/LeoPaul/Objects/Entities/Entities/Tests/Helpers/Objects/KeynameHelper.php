<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname;

final class KeynameHelper {
    private $phpunit;
    private $keynameMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Keyname $keynameMock) {
        $this->phpunit = $phpunit;
        $this->keynameMock = $keynameMock;
    }

    public function expectsGetName_Success($returnedName) {
        $this->keynameMock->expects($this->phpunit->once())
                            ->method('getName')
                            ->will($this->phpunit->returnValue($returnedName));
    }

    public function expectsGetName_multiple_Success(array $returnedNames) {

        $amount = count($returnedNames);
        $this->keynameMock->expects($this->phpunit->exactly($amount))
                            ->method('getName')
                            ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedNames));
    }

    public function expectsGetValue_Success($returnedValue) {
        $this->keynameMock->expects($this->phpunit->once())
                            ->method('getValue')
                            ->will($this->phpunit->returnValue($returnedValue));
    }

    public function expectsGetValue_multiple_Success(array $returnedValues) {

        $amount = count($returnedValues);
        $this->keynameMock->expects($this->phpunit->exactly($amount))
                            ->method('getValue')
                            ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedValues));
    }

}
