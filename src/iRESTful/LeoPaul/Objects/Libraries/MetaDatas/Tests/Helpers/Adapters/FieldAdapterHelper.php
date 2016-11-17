<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Adapters\FieldAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Exceptions\FieldException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field;

final class FieldAdapterHelper {
    private $phpunit;
    private $fieldAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, FieldAdapter $fieldAdapterMock) {
        $this->phpunit = $phpunit;
        $this->fieldAdapterMock = $fieldAdapterMock;
    }

    public function expectsFromDataToField_Success(Field $returnedField, array $data) {
        $this->fieldAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToField')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedField));
    }

    public function expectsFromDataToFields_Success(array $returnedFields, array $data) {
        $this->fieldAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToFields')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedFields));
    }

    public function expectsFromDataToFields_throwsFieldException(array $data) {
        $this->fieldAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToFields')
                                ->with($data)
                                ->will($this->phpunit->throwException(new FieldException('TEST')));
    }

}
