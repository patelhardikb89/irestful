<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Adapters\ClientAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Objects\TestPDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcreteServerAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Exceptions\ServerException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Objects\NativePDOHelper;

final class ConcreteServerAdapterTest extends \PHPUnit_Framework_TestCase {
    private $clientAdapterMock;
    private $clientMock;
    private $nativePDOMock;
    private $pdo;
    private $pdoThrowsException;
    private $driver;
    private $hostName;
    private $database;
    private $username;
    private $stats;
    private $version;
    private $adapter;
    private $nativePDOHelper;
    private $clientAdapterHelper;
    public function setUp() {
        $this->clientAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Adapters\ClientAdapter');
        $this->clientMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Client');
        $this->nativePDOMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\NativePDO');

        $this->pdo = new TestPDO();
        $this->pdoThrowsException = new TestPDO(true);

        $this->driver = 'mysql';
        $this->hostName = '127.0.0.1';
        $this->database = 'my_db';
        $this->username = 'root';
        $this->stats = 'lets say this is some stats.';
        $this->version = 'v12.11.22';

        $this->adapter = new ConcreteServerAdapter($this->clientAdapterMock);

        $this->nativePDOHelper = new NativePDOHelper($this, $this->nativePDOMock);
        $this->clientAdapterHelper = new ClientAdapterHelper($this, $this->clientAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromNativePDOToServer_Success() {

        $this->nativePDOHelper->expectsGetPDO_Success($this->pdo);
        $this->nativePDOHelper->expectsGetHostName_Success($this->hostName);
        $this->nativePDOHelper->expectsGetDatabase_Success($this->database);
        $this->nativePDOHelper->expectsGetUsername_Success($this->username);
        $this->nativePDOHelper->expectsGetDriver_Success($this->driver);
        $this->clientAdapterHelper->expectsFromNativePDOToClient_Success($this->clientMock, $this->pdo);

        $server = $this->adapter->fromNativePDOToServer($this->nativePDOMock);

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

    public function testFromNativePDOToServer_throwsPDOException_throwsServerException() {

        $this->nativePDOHelper->expectsGetPDO_Success($this->pdoThrowsException);
        $this->nativePDOHelper->expectsGetHostName_Success($this->hostName);
        $this->nativePDOHelper->expectsGetDatabase_Success($this->database);
        $this->nativePDOHelper->expectsGetUsername_Success($this->username);
        $this->nativePDOHelper->expectsGetDriver_Success($this->driver);
        $this->clientAdapterHelper->expectsFromNativePDOToClient_Success($this->clientMock, $this->pdoThrowsException);

        $asserted = false;
        try {

            $this->adapter->fromNativePDOToServer($this->nativePDOMock);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromNativePDOToServer_throwsClientException_throwsServerException() {

        $this->nativePDOHelper->expectsGetPDO_Success($this->pdo);
        $this->nativePDOHelper->expectsGetHostName_Success($this->hostName);
        $this->nativePDOHelper->expectsGetDatabase_Success($this->database);
        $this->nativePDOHelper->expectsGetUsername_Success($this->username);
        $this->nativePDOHelper->expectsGetDriver_Success($this->driver);
        $this->clientAdapterHelper->expectsFromNativePDOToClient_throwsClientException($this->pdo);

        $asserted = false;
        try {

            $this->adapter->fromNativePDOToServer($this->nativePDOMock);

        } catch (ServerException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
