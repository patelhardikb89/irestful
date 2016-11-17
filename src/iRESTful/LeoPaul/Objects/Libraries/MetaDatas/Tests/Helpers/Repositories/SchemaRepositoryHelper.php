<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Repositories;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Repositories\SchemaRepository;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Schema;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Exceptions\SchemaException;

final class SchemaRepositoryHelper {
    private $phpunit;
    private $schemaRepositoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, SchemaRepository $schemaRepositoryMock) {
        $this->phpunit = $phpunit;
        $this->schemaRepositoryMock = $schemaRepositoryMock;
    }

    public function expectsRetrieve_Success(Schema $returnedSchema, array $criteria) {
        $this->schemaRepositoryMock->expects($this->phpunit->once())
                                    ->method('retrieve')
                                    ->with($criteria)
                                    ->will($this->phpunit->returnValue($returnedSchema));
    }

    public function expectsRetrieve_throwsSchemaException(array $criteria) {
        $this->schemaRepositoryMock->expects($this->phpunit->once())
                                    ->method('retrieve')
                                    ->with($criteria)
                                    ->will($this->phpunit->throwException(new SchemaException('TEST')));
    }

}
