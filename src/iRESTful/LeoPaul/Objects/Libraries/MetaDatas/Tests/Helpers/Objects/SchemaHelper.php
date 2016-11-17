<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Schema;

final class SchemaHelper {
    private $phpunit;
    private $schemaMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Schema $schemaMock) {
        $this->phpunit = $phpunit;
        $this->schemaMock = $schemaMock;
    }

    public function expectsGetName_Success($returnedName) {
        $this->schemaMock->expects($this->phpunit->once())
                            ->method('getName')
                            ->will($this->phpunit->returnValue($returnedName));
    }

    public function expectsHasTables_Success($returnedBoolean) {
        $this->schemaMock->expects($this->phpunit->once())
                            ->method('hasTables')
                            ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetTables_Success(array $returnedTables) {
        $this->schemaMock->expects($this->phpunit->once())
                            ->method('getTables')
                            ->will($this->phpunit->returnValue($returnedTables));
    }

}
