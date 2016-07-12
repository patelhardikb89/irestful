<?php
namespace iRESTful\Rodson\Tests\Helpers\Objects;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapter;

final class TypeHelper {
    private $phpunit;
    private $typeMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Type $typeMock) {
        $this->phpunit = $phpunit;
        $this->typeMock = $typeMock;
    }

    public function expectsGetName_Success($returnedName) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('getName')
                        ->will($this->phpunit->returnValue($returnedName));
    }

    public function expectsGetName_multiple_Success(array $returnedNames) {
        $amount = count($returnedNames);
        $this->typeMock->expects($this->phpunit->exactly($amount))
                        ->method('getName')
                        ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedNames));
    }

    public function expectsHasDatabaseAdapter_Success($returnedBoolean) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('hasDatabaseAdapter')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetDatabaseAdapter_Success(Adapter $returnedAdapter) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('getDatabaseAdapter')
                        ->will($this->phpunit->returnValue($returnedAdapter));
    }

    public function expectsHasViewAdapter_Success($returnedBoolean) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('hasViewAdapter')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetViewAdapter_Success(Adapter $returnedAdapter) {
        $this->typeMock->expects($this->phpunit->once())
                        ->method('getViewAdapter')
                        ->will($this->phpunit->returnValue($returnedAdapter));
    }

}
