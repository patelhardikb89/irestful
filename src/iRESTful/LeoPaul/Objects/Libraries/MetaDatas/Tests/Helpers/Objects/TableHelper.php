<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field;

final class TableHelper {
    private $phpunit;
    private $tableMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Table $tableMock) {
        $this->phpunit = $phpunit;
        $this->tableMock = $tableMock;
    }

    public function expectsHasPrimaryKey_Success($returnedBoolean) {
        $this->tableMock->expects($this->phpunit->once())
                        ->method('hasPrimaryKey')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsHasPrimaryKey_multiple_Success(array $returnedBooleans) {
        $amount = count($returnedBooleans);
        $this->tableMock->expects($this->phpunit->exactly($amount))
                        ->method('hasPrimaryKey')
                        ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedBooleans));
    }

    public function expectsGetPrimaryKey_Success(Field $returnedField) {
        $this->tableMock->expects($this->phpunit->once())
                        ->method('getPrimaryKey')
                        ->will($this->phpunit->returnValue($returnedField));
    }

    public function expectsGetPrimaryKey_multiple_Success(array $returnedFields) {
        $amount = count($returnedFields);
        $this->tableMock->expects($this->phpunit->exactly($amount))
                        ->method('getPrimaryKey')
                        ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedFields));
    }

    public function expectsGetName_Success($returnedName) {
        $this->tableMock->expects($this->phpunit->once())
                        ->method('getName')
                        ->will($this->phpunit->returnValue($returnedName));
    }

    public function expectsGetName_multiple_Success(array $returnedNames) {
        $amount = count($returnedNames);
        $this->tableMock->expects($this->phpunit->exactly($amount))
                        ->method('getName')
                        ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedNames));
    }

    public function expectsGetEngine_Success($returnedEngine) {
        $this->tableMock->expects($this->phpunit->once())
                        ->method('getEngine')
                        ->will($this->phpunit->returnValue($returnedEngine));
    }

    public function expectsGetFields_Success(array $returnedFields) {
        $this->tableMock->expects($this->phpunit->once())
                        ->method('getFields')
                        ->will($this->phpunit->returnValue($returnedFields));
    }

}
