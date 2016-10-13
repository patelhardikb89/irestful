<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteDatabase;
use iRESTful\DSLs\Domain\Projects\Databases\Exceptions\DatabaseException;

final class ConcreteDatabaseTest extends \PHPUnit_Framework_TestCase {
    private $relationalDatabaseMock;
    private $restAPIMock;
    private $name;
    public function setUp() {
        $this->relationalDatabaseMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Databases\Relationals\RelationalDatabase');
        $this->restAPIMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Databases\RESTAPIs\RESTAPI');

        $this->name = 'my_name';
    }

    public function tearDown() {

    }

    public function testCreate_withRelationalDatabase_Success() {

        $database = new ConcreteDatabase($this->name, $this->relationalDatabaseMock);

        $this->assertEquals($this->name, $database->getName());
        $this->assertTrue($database->hasRelational());
        $this->assertEquals($this->relationalDatabaseMock, $database->getRelational());
        $this->assertFalse($database->hasRESTAPI());
        $this->assertNull($database->getRESTAPI());
    }

    public function testCreate_withRESTAPI_Success() {

        $database = new ConcreteDatabase($this->name, null, $this->restAPIMock);

        $this->assertEquals($this->name, $database->getName());
        $this->assertFalse($database->hasRelational());
        $this->assertNull($database->getRelational());
        $this->assertTrue($database->hasRESTAPI());
        $this->assertEquals($this->restAPIMock, $database->getRESTAPI());
    }

    public function testCreate_withEmptyName_Success() {

        $asserted = false;
        try {

            new ConcreteDatabase('', null, $this->restAPIMock);

        } catch (DatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withRelationalDatabase_withRESTAPI_throwsDatabaseException() {

        $asserted = false;
        try {

            new ConcreteDatabase($this->name, $this->relationalDatabaseMock, $this->restAPIMock);

        } catch (DatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withoutDatabase_throwsDatabaseException() {

        $asserted = false;
        try {

            new ConcreteDatabase($this->name);

        } catch (DatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
