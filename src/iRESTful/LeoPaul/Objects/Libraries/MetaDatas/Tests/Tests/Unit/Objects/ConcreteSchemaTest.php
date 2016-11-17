<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteSchema;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Exceptions\SchemaException;

final class ConcreteSchemaTest extends \PHPUnit_Framework_TestCase {
    private $tableMock;
    private $name;
    private $tables;
    public function setUp() {
        $this->tableMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table');

        $this->name = 'my_schema';

        $this->tables = [
            $this->tableMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $schema = new ConcreteSchema($this->name);

        $this->assertEquals($this->name, $schema->getName());
        $this->assertFalse($schema->hasTables());
        $this->assertNull($schema->getTables());

    }

    public function testCreate_withEmptyTables_Success() {

        $schema = new ConcreteSchema($this->name, []);

        $this->assertEquals($this->name, $schema->getName());
        $this->assertFalse($schema->hasTables());
        $this->assertNull($schema->getTables());

    }

    public function testCreate_withTables_Success() {

        $schema = new ConcreteSchema($this->name, $this->tables);

        $this->assertEquals($this->name, $schema->getName());
        $this->assertTrue($schema->hasTables());
        $this->assertEquals($this->tables, $schema->getTables());

    }

    public function testCreate_withOneInvalidTable_throwsSchemaException() {

        $this->tables[] = new \DateTime();

        $asserted = false;

        try {

            new ConcreteSchema($this->name, $this->tables);

        } catch (SchemaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsSchemaException() {

        $asserted = false;

        try {

            new ConcreteSchema('');

        } catch (SchemaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsSchemaException() {

        $asserted = false;

        try {

            new ConcreteSchema('');

        } catch (SchemaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidName_throwsSchemaException() {

        $asserted = false;

        try {

            new ConcreteSchema('SomeInvalid9');

        } catch (SchemaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
