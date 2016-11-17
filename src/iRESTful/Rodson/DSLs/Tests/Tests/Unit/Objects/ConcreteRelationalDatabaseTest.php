<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteRelationalDatabase;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Relationals\Exceptions\RelationalDatabaseException;

final class ConcreteRelationalDatabaseTest extends \PHPUnit_Framework_TestCase {
    private $credentialsMock;
    private $driver;
    private $ipAddress;
    private $hostName;
    private $engine;
    public function setUp() {

        $this->credentialsMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Databases\Credentials\Credentials');

        $this->driver = 'mysql';
        $this->ipAddress = '127.0.0.1';
        $this->hostName = 'db.irestful.com';
        $this->engine = 'InnoDB';

    }

    public function tearDown() {

    }

    public function testCreate_withIpAddress_Success() {

        $relationalDatabase = new ConcreteRelationalDatabase($this->driver, $this->ipAddress, $this->engine);

        $this->assertEquals($this->driver, $relationalDatabase->getDriver());
        $this->assertEquals($this->ipAddress, $relationalDatabase->getHostName());
        $this->assertEquals($this->engine, $relationalDatabase->getEngine());
        $this->assertFalse($relationalDatabase->hasCredentials());
        $this->assertNull($relationalDatabase->getCredentials());

    }

    public function testCreate_withHostName_Success() {

        $relationalDatabase = new ConcreteRelationalDatabase($this->driver, $this->hostName, $this->engine);

        $this->assertEquals($this->driver, $relationalDatabase->getDriver());
        $this->assertEquals($this->hostName, $relationalDatabase->getHostName());
        $this->assertEquals($this->engine, $relationalDatabase->getEngine());
        $this->assertFalse($relationalDatabase->hasCredentials());
        $this->assertNull($relationalDatabase->getCredentials());

    }

    public function testCreate_withHostName_withCredentials_Success() {

        $relationalDatabase = new ConcreteRelationalDatabase($this->driver, $this->hostName, $this->engine, $this->credentialsMock);

        $this->assertEquals($this->driver, $relationalDatabase->getDriver());
        $this->assertEquals($this->hostName, $relationalDatabase->getHostName());
        $this->assertEquals($this->engine, $relationalDatabase->getEngine());
        $this->assertTrue($relationalDatabase->hasCredentials());
        $this->assertEquals($this->credentialsMock, $relationalDatabase->getCredentials());

    }

    public function testCreate_withEmptyEngine_Success() {

        $asserted = false;
        try {

            new ConcreteRelationalDatabase($this->driver, $this->hostName, '');

        } catch (RelationalDatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyHostName_Success() {

        $asserted = false;
        try {

            new ConcreteRelationalDatabase($this->driver, '', $this->engine);

        } catch (RelationalDatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyDriver_Success() {

        $asserted = false;
        try {

            new ConcreteRelationalDatabase('', $this->hostName, $this->engine);

        } catch (RelationalDatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
