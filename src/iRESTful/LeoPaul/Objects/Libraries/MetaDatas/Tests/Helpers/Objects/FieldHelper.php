<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\ForeignKey;

final class FieldHelper {
    private $phpunit;
    private $fieldMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Field $fieldMock) {
        $this->phpunit = $phpunit;
        $this->fieldMock = $fieldMock;
    }

    public function expectsGetName_Success($returnedName) {
        $this->fieldMock->expects($this->phpunit->once())
                        ->method('getName')
                        ->will($this->phpunit->returnValue($returnedName));
    }

    public function expectsGetName_multiple_Success(array $returnedNames) {
        $amount = count($returnedNames);
        $this->fieldMock->expects($this->phpunit->exactly($amount))
                        ->method('getName')
                        ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedNames));
    }

    public function expectsGetType_Success(Type $returnedType) {
        $this->fieldMock->expects($this->phpunit->once())
                        ->method('getType')
                        ->will($this->phpunit->returnValue($returnedType));
    }
    
    public function expectsGetType_multiple_Success(array $returnedTypes) {
        $amount = count($returnedTypes);
        $this->fieldMock->expects($this->phpunit->exactly($amount))
                        ->method('getType')
                        ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedTypes));
    }

    public function expectsHasForeignKey_Success($returnedBoolean) {
        $this->fieldMock->expects($this->phpunit->once())
                        ->method('hasForeignKey')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsHasForeignKey_multiple_Success(array $returnedBooleans) {
        $amount = count($returnedBooleans);
        $this->fieldMock->expects($this->phpunit->exactly($amount))
                        ->method('hasForeignKey')
                        ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedBooleans));
    }

    public function expectsGetForeignKey_Success(ForeignKey $returnedForeignKey) {
        $this->fieldMock->expects($this->phpunit->once())
                        ->method('getForeignKey')
                        ->will($this->phpunit->returnValue($returnedForeignKey));
    }

    public function expectsGetForeignKey_multiple_Success(array $returnedForeignKeys) {
        $amount = count($returnedForeignKeys);
        $this->fieldMock->expects($this->phpunit->exactly($amount))
                        ->method('getForeignKey')
                        ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedForeignKeys));
    }

    public function expectsIsPrimaryKey_Success($returnedBoolean) {
        $this->fieldMock->expects($this->phpunit->once())
                        ->method('isPrimaryKey')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsIsPrimaryKey_multiple_Success(array $returnedBooleans) {
        $amount = count($returnedBooleans);
        $this->fieldMock->expects($this->phpunit->exactly($amount))
                        ->method('isPrimaryKey')
                        ->will(call_user_func_array(array($this->phpunit, 'onConsecutiveCalls'), $returnedBooleans));
    }

    public function expectsIsNullable_Success($returnedBoolean) {
        $this->fieldMock->expects($this->phpunit->once())
                        ->method('isNullable')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsHasDefault_Success($returnedBoolean) {
        $this->fieldMock->expects($this->phpunit->once())
                        ->method('hasDefault')
                        ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetDefault_Success($returnedDefault) {
        $this->fieldMock->expects($this->phpunit->once())
                        ->method('getDefault')
                        ->will($this->phpunit->returnValue($returnedDefault));
    }

}
