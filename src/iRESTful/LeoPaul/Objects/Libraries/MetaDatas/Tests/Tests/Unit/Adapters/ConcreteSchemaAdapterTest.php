<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters\ConcreteSchemaAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters\TableAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Exceptions\SchemaException;

final class ConcreteSchemaAdapterTest extends \PHPUnit_Framework_TestCase {
    private $tableAdapterMock;
    private $tableMock;
    private $tables;
    private $name;
    private $containerNames;
    private $data;
    private $adapter;
    private $tableAdapterHelper;
    public function setUp() {
        $this->tableAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Adapters\TableAdapter');
        $this->tableMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table');

        $this->tables = [
            $this->tableMock,
            $this->tableMock
        ];

        $this->name = 'my_name';

        $this->containerNames = [
            'some',
            'containers'
        ];

        $this->data = [
            'name' => $this->name,
            'container_names' => $this->containerNames
        ];

        $this->adapter = new ConcreteSchemaAdapter($this->tableAdapterMock);

        $this->tableAdapterHelper = new TableAdapterHelper($this, $this->tableAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToSchema_Success() {

        unset($this->data['container_names']);

        $schema = $this->adapter->fromDataToSchema($this->data);

        $this->assertEquals($this->name, $schema->getName());
        $this->assertFalse($schema->hasTables());
        $this->assertNull($schema->getTables());
    }

    public function testFromDataToSchema_withTables_Success() {

        $this->tableAdapterHelper->expectsFromDataToTables_Success($this->tables, $this->containerNames);

        $schema = $this->adapter->fromDataToSchema($this->data);

        $this->assertEquals($this->name, $schema->getName());
        $this->assertTrue($schema->hasTables());
        $this->assertEquals($this->tables, $schema->getTables());
    }

    public function testFromDataToSchema_withTables_throwsTableException_throwsSchemaException() {

        $this->tableAdapterHelper->expectsFromDataToTables_throwsTableException($this->containerNames);

        $asserted = false;
        try {

            $this->adapter->fromDataToSchema($this->data);

        } catch (SchemaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToSchema_withoutName_throwsSchemaException() {

        unset($this->data['name']);

        $asserted = false;
        try {

            $this->adapter->fromDataToSchema($this->data);

        } catch (SchemaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
