<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteRelationalDatabase;
use iRESTful\Rodson\Domain\Inputs\Projects\Databases\Relationals\Exceptions\RelationalDatabaseException;

final class ConcreteRelationalDatabaseTest extends \PHPUnit_Framework_TestCase {
    private $credentialsMock;
    private $driver;
    private $ipAddress;
    private $hostName;
    public function setUp() {

        $this->credentialsMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Projects\Databases\Credentials\Credentials');

        $this->driver = 'mysql';
        $this->ipAddress = '127.0.0.1';
        $this->hostName = 'db.irestful.com';

    }

    public function tearDown() {

    }

    public function testCreate_withIpAddress_Success() {

        $relationalDatabase = new ConcreteRelationalDatabase($this->driver, $this->ipAddress);

        $this->assertEquals($this->driver, $relationalDatabase->getDriver());
        $this->assertEquals($this->ipAddress, $relationalDatabase->getHostName());
        $this->assertFalse($relationalDatabase->hasCredentials());
        $this->assertNull($relationalDatabase->getCredentials());

    }

    public function testCreate_withHostName_Success() {

        $relationalDatabase = new ConcreteRelationalDatabase($this->driver, $this->hostName);

        $this->assertEquals($this->driver, $relationalDatabase->getDriver());
        $this->assertEquals($this->hostName, $relationalDatabase->getHostName());
        $this->assertFalse($relationalDatabase->hasCredentials());
        $this->assertNull($relationalDatabase->getCredentials());

    }

    public function testCreate_withHostName_withCredentials_Success() {

        $relationalDatabase = new ConcreteRelationalDatabase($this->driver, $this->hostName, $this->credentialsMock);

        $this->assertEquals($this->driver, $relationalDatabase->getDriver());
        $this->assertEquals($this->hostName, $relationalDatabase->getHostName());
        $this->assertTrue($relationalDatabase->hasCredentials());
        $this->assertEquals($this->credentialsMock, $relationalDatabase->getCredentials());

    }

    public function testCreate_withEmptyHostName_Success() {

        $asserted = false;
        try {

            new ConcreteRelationalDatabase($this->driver, '');

        } catch (RelationalDatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringHostName_Success() {

        $asserted = false;
        try {

            new ConcreteRelationalDatabase($this->driver, new \DateTime());

        } catch (RelationalDatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyDriver_Success() {

        $asserted = false;
        try {

            new ConcreteRelationalDatabase('', $this->hostName);

        } catch (RelationalDatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringDriver_Success() {

        $asserted = false;
        try {

            new ConcreteRelationalDatabase(new \DateTime(), $this->hostName);

        } catch (RelationalDatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
