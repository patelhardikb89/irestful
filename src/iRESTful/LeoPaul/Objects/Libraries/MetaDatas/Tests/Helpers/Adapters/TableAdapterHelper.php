<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Adapters\TableAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;

final class TableAdapterHelper {
    private $phpunit;
    private $tableAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, TableAdapter $tableAdapterMock) {
        $this->phpunit = $phpunit;
        $this->tableAdapterMock = $tableAdapterMock;
    }

    public function expectsFromDataToTables_Success(array $returnedTables, array $data) {
        $this->tableAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToTables')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedTables));
    }

    public function expectsFromDataToTables_throwsTableException(array $data) {
        $this->tableAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToTables')
                                ->with($data)
                                ->will($this->phpunit->throwException(new TableException('TEST')));
    }

    public function expectsFromDataToTable_Success(Table $returnedTable, array $data) {
        $this->tableAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToTable')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedTable));
    }

    public function expectsFromDataToTable_throwsTableException(array $data) {
        $this->tableAdapterMock->expects($this->phpunit->once())
                                ->method('fromDataToTable')
                                ->with($data)
                                ->will($this->phpunit->throwException(new TableException('TEST')));
    }

    public function expectsFromClassMetaDataToTable_Success(Table $returnedTable, ClassMetaData $classMetaDataMock) {
        $this->tableAdapterMock->expects($this->phpunit->once())
                                ->method('fromClassMetaDataToTable')
                                ->with($classMetaDataMock)
                                ->will($this->phpunit->returnValue($returnedTable));
    }

}
