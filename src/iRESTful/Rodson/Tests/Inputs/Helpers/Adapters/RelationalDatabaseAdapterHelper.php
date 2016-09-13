<?php
namespace iRESTful\Rodson\Tests\Inputs\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Databases\Relationals\Adapters\RelationalDatabaseAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Databases\Relationals\RelationalDatabase;
use iRESTful\Rodson\Domain\Inputs\Projects\Databases\Relationals\Exceptions\RelationalDatabaseException;

final class RelationalDatabaseAdapterHelper {
    private $phpunit;
    private $relationalDatabaseAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RelationalDatabaseAdapter $relationalDatabaseAdapterMock) {
        $this->phpunit = $phpunit;
        $this->relationalDatabaseAdapterMock = $relationalDatabaseAdapterMock;
    }

    public function expectsFromDataToRelationalDatabase_Success(RelationalDatabase $returnedDatabase, array $data) {
        $this->relationalDatabaseAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToRelationalDatabase')
                                            ->with($data)
                                            ->will($this->phpunit->returnValue($returnedDatabase));
    }

    public function expectsFromDataToRelationalDatabase_throwsRelationalDatabaseException(array $data) {
        $this->relationalDatabaseAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToRelationalDatabase')
                                            ->with($data)
                                            ->will($this->phpunit->throwException(new RelationalDatabaseException('TEST')));
    }

}
