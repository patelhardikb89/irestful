<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTable;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\FieldHelper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;

final class ConcreteTableTest extends \PHPUnit_Framework_TestCase {
    private $fieldMock;
    private $name;
    private $engine;
    private $fields;
    private $fieldHelper;
    public function setUp() {
        $this->fieldMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field');

        $this->name = 'my_table';
        $this->engine = 'innodb';

        $this->fields = [
            $this->fieldMock,
            $this->fieldMock
        ];

        $this->fieldHelper = new FieldHelper($this, $this->fieldMock);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $this->fieldHelper->expectsIsPrimaryKey_Success(true);

        $table = new ConcreteTable($this->name, $this->engine, $this->fields);

        $this->assertEquals($this->name, $table->getName());
        $this->assertEquals($this->engine, $table->getEngine());
        $this->assertTrue($table->hasPrimaryKey());
        $this->assertEquals($this->fieldMock, $table->getPrimaryKey());
        $this->assertEquals($this->fields, $table->getFields());
    }

    public function testCreate_withClusterEngine_Success() {

        $table = new ConcreteTable($this->name, 'cluster', $this->fields);

        $this->assertEquals($this->name, $table->getName());
        $this->assertEquals('cluster', $table->getEngine());
        $this->assertFalse($table->hasPrimaryKey());
        $this->assertNull($table->getPrimaryKey());
        $this->assertEquals($this->fields, $table->getFields());
    }

    public function testCreate_withFields_secondFieldIsPrimaryKey_Success() {

        $this->fieldHelper->expectsIsPrimaryKey_multiple_Success([false, true]);

        $table = new ConcreteTable($this->name, $this->engine, $this->fields);

        $this->assertEquals($this->name, $table->getName());
        $this->assertEquals($this->engine, $table->getEngine());
        $this->assertTrue($table->hasPrimaryKey());
        $this->assertEquals($this->fieldMock, $table->getPrimaryKey());
        $this->assertEquals($this->fields, $table->getFields());
    }

    public function testCreate_withFields_withoutPrimaryKey_Success() {

        $this->fieldHelper->expectsIsPrimaryKey_multiple_Success([false, false]);

        $table = new ConcreteTable($this->name, $this->engine, $this->fields);

        $this->assertEquals($this->name, $table->getName());
        $this->assertEquals($this->engine, $table->getEngine());
        $this->assertFalse($table->hasPrimaryKey());
        $this->assertNull($table->getPrimaryKey());
        $this->assertEquals($this->fields, $table->getFields());
    }

    public function testCreate_withEmptyFields_Success() {

        $asserted = false;
        try {

            new ConcreteTable($this->name, $this->engine, []);

        } catch (TableException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withOneInvalidField_throwsTableException() {

        $this->fields[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteTable($this->name, $this->engine, $this->fields);

        } catch (TableException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withInvalidEngine_throwsTableException() {

        $asserted = false;
        try {

            new ConcreteTable($this->name, 'invalid', $this->fields);

        } catch (TableException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withInvalidName_throwsTableException() {

        $asserted = false;
        try {

            new ConcreteTable('invalidName9', $this->engine, $this->fields);

        } catch (TableException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withEmptyName_throwsTableException() {

        $asserted = false;
        try {

            new ConcreteTable('', $this->engine, $this->fields);

        } catch (TableException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withNonStringName_throwsTableException() {

        $asserted = false;
        try {

            new ConcreteTable('', $this->engine, $this->fields);

        } catch (TableException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
