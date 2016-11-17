<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects\ConcreteServer;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Exceptions\ServerException;

final class ConcreteServerTest extends \PHPUnit_Framework_TestCase {
    private $clientMock;
    private $driver;
    private $hostName;
    private $database;
    private $username;
    private $stats;
    private $version;
    public function setUp() {

        $this->clientMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Client');

        $this->driver = 'mysql';
        $this->hostName = '127.0.0.1';
        $this->database = 'my_database';
        $this->username = 'root';
        $this->stats = 'Lets say this is some database stats.';
        $this->version = 'v12.44.33';

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $server = new ConcreteServer($this->clientMock, $this->driver, $this->hostName, $this->database, $this->username, $this->stats, $this->version, false, false);

        $this->assertEquals($this->clientMock, $server->getClient());
        $this->assertEquals($this->driver, $server->getDriver());
        $this->assertEquals($this->hostName, $server->getHostname());
        $this->assertEquals($this->database, $server->getDatabase());
        $this->assertEquals($this->username, $server->getUsername());
        $this->assertEquals($this->stats, $server->getStats());
        $this->assertEquals($this->version, $server->getVersion());
        $this->assertFalse($server->isPersistent());
        $this->assertFalse($server->isAutoCommit());

    }

    public function testCreate_isAutoCommit_Success() {

        $server = new ConcreteServer($this->clientMock, $this->driver, $this->hostName, $this->database, $this->username, $this->stats, $this->version, false, true);

        $this->assertEquals($this->clientMock, $server->getClient());
        $this->assertEquals($this->driver, $server->getDriver());
        $this->assertEquals($this->hostName, $server->getHostname());
        $this->assertEquals($this->database, $server->getDatabase());
        $this->assertEquals($this->username, $server->getUsername());
        $this->assertEquals($this->stats, $server->getStats());
        $this->assertEquals($this->version, $server->getVersion());
        $this->assertFalse($server->isPersistent());
        $this->assertTrue($server->isAutoCommit());

    }

    public function testCreate_isPersistent_Success() {

        $server = new ConcreteServer($this->clientMock, $this->driver, $this->hostName, $this->database, $this->username, $this->stats, $this->version, true, false);

        $this->assertEquals($this->clientMock, $server->getClient());
        $this->assertEquals($this->driver, $server->getDriver());
        $this->assertEquals($this->hostName, $server->getHostname());
        $this->assertEquals($this->database, $server->getDatabase());
        $this->assertEquals($this->username, $server->getUsername());
        $this->assertEquals($this->stats, $server->getStats());
        $this->assertEquals($this->version, $server->getVersion());
        $this->assertTrue($server->isPersistent());
        $this->assertFalse($server->isAutoCommit());

    }

    public function testCreate_isPersistent_isAutoCommit_Success() {

        $server = new ConcreteServer($this->clientMock, $this->driver, $this->hostName, $this->database, $this->username, $this->stats, $this->version, true, true);

        $this->assertEquals($this->clientMock, $server->getClient());
        $this->assertEquals($this->driver, $server->getDriver());
        $this->assertEquals($this->hostName, $server->getHostname());
        $this->assertEquals($this->database, $server->getDatabase());
        $this->assertEquals($this->username, $server->getUsername());
        $this->assertEquals($this->stats, $server->getStats());
        $this->assertEquals($this->version, $server->getVersion());
        $this->assertTrue($server->isPersistent());
        $this->assertTrue($server->isAutoCommit());

    }

    public function testCreate_withEmptyVersion_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, $this->driver, $this->hostName, $this->database, $this->username, $this->stats, '', false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringVersion_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, $this->driver, $this->hostName, $this->database, $this->username, $this->stats, new \DateTime(), false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyStats_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, $this->driver, $this->hostName, $this->database, $this->username, '', $this->version, false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringStats_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, $this->driver, $this->hostName, $this->database, $this->username, new \DateTime(), $this->version, false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyUsername_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, $this->driver, $this->hostName, $this->database, '', $this->stats, $this->version, false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringUsername_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, $this->driver, $this->hostName, $this->database,  new \DateTime(), $this->stats, $this->version, false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyDatabase_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, $this->driver, $this->hostName, '', $this->username, $this->stats, $this->version, false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringDatabase_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, $this->driver, $this->hostName, new \DateTime(),  $this->username, $this->stats, $this->version, false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyHostName_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, $this->driver, '', $this->database, $this->username, $this->stats, $this->version, false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringHostName_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, $this->driver, new \DateTime(), $this->database,  $this->username, $this->stats, $this->version, false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyDriver_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, '', $this->hostName, $this->database, $this->username, $this->stats, $this->version, false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringDriver_throwsServerException() {

        $asserted = false;
        try {

            new ConcreteServer($this->clientMock, new \DateTime(), $this->hostName, $this->database,  $this->username, $this->stats, $this->version, false, false);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
