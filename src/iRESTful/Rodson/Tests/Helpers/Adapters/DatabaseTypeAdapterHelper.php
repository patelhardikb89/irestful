<?php
namespace iRESTful\Rodson\Tests\Helpers\Adapters;
use iRESTful\Rodson\Domain\Types\Databases\Adapters\DatabaseTypeAdapter;
use iRESTful\Rodson\Domain\Types\Databases\DatabaseType;
use iRESTful\Rodson\Domain\Types\Databases\Exceptions\DatabaseTypeException;

final class DatabaseTypeAdapterHelper {
    private $phpunit;
    private $databaseTypeAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, DatabaseTypeAdapter $databaseTypeAdapterMock) {
        $this->phpunit = $phpunit;
        $this->databaseTypeAdapterMock = $databaseTypeAdapterMock;
    }

    public function expectsFromDataToDatabaseType_Success(DatabaseType $returnedType, array $data) {
        $this->databaseTypeAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToDatabaseType')
                                        ->with($data)
                                        ->will($this->phpunit->returnValue($returnedType));
    }

    public function expectsFromDataToDatabaseType_throwsDatabaseTypeException(array $data) {
        $this->databaseTypeAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToDatabaseType')
                                        ->with($data)
                                        ->will($this->phpunit->throwException(new DatabaseTypeException('TEST')));
    }

}
