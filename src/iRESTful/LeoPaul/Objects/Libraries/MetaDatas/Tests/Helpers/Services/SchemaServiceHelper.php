<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Services;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Services\SchemaService;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Schema;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Exceptions\SchemaException;

final class SchemaServiceHelper {
    private $phpunit;
    private $schemaServiceMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, SchemaService $schemaServiceMock) {
        $this->phpunit = $phpunit;
        $this->schemaServiceMock = $schemaServiceMock;
    }

    public function expectsInsert_Success(Schema $returnedSchema) {
        $this->schemaServiceMock->expects($this->phpunit->once())
                                    ->method('insert')
                                    ->will($this->phpunit->returnValue($returnedSchema));
    }

    public function expectsInsert_throwsSchemaException(Schema $returnedSchema) {
        $this->schemaServiceMock->expects($this->phpunit->once())
                                    ->method('insert')
                                    ->will($this->phpunit->throwException(new SchemaException('TEST')));
    }

    public function expectsDelete_Success(Schema $returnedSchema) {
        $this->schemaServiceMock->expects($this->phpunit->once())
                                    ->method('delete')
                                    ->will($this->phpunit->returnValue($returnedSchema));
    }

    public function expectsDelete_throwsSchemaException(Schema $returnedSchema) {
        $this->schemaServiceMock->expects($this->phpunit->once())
                                    ->method('delete')
                                    ->will($this->phpunit->throwException(new SchemaException('TEST')));
    }

}
