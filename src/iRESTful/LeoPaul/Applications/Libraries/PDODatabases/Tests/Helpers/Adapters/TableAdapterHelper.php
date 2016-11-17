<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Adapters\TableAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;

final class TableAdapterHelper {
    private $phpunit;
    private $tableAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, TableAdapter $tableAdapterMock) {
        $this->phpunit = $phpunit;
        $this->tableAdapterMock = $tableAdapterMock;
    }

    public function expectsFromTablesToSQLQueries_Success(array $returnedSQLQueries, array $tables) {
        $this->tableAdapterMock->expects($this->phpunit->once())
                                ->method('fromTablesToSQLQueries')
                                ->with($tables)
                                ->will($this->phpunit->returnValue($returnedSQLQueries));
    }

    public function expectsFromTablesToSQLQueries_throwsTableException(array $tables) {
        $this->tableAdapterMock->expects($this->phpunit->once())
                                ->method('fromTablesToSQLQueries')
                                ->with($tables)
                                ->will($this->phpunit->throwException(new TableException('TEST')));
    }

}
