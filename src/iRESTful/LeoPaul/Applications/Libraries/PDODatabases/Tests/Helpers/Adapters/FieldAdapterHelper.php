<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Fields\Adapters\FieldAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Exceptions\FieldException;

final class FieldAdapterHelper {
    private $phpunit;
    private $fieldAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, FieldAdapter $fieldAdapterMock) {
        $this->phpunit = $phpunit;
        $this->fieldAdapterMock = $fieldAdapterMock;
    }

    public function expectsFromFieldsToSQLQueryLines_Success(array $returnedSQLQueryLines, array $fields) {
        $this->fieldAdapterMock->expects($this->phpunit->once())
                                ->method('fromFieldsToSQLQueryLines')
                                ->with($fields)
                                ->will($this->phpunit->returnValue($returnedSQLQueryLines));
    }

    public function expectsFromDataToSQLQueries_Success(array $returnedSQLQueries, array $data) {
        $this->fieldAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToSQLQueries')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedSQLQueries));
    }

    public function expectsFromDataToSQLQueries_throwsFieldException(array $data) {
        $this->fieldAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToSQLQueries')
                                ->with($data)
                                ->will($this->phpunit->throwException(new FieldException('TEST')));
    }

}
