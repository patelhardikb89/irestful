<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteRelationalDatabaseAdapter;
use iRESTful\Rodson\Tests\Helpers\Adapters\CredentialsAdapterHelper;
use iRESTful\Rodson\Domain\Inputs\Databases\Relationals\Exceptions\RelationalDatabaseException;

final class ConcreteRelationalDatabaseAdapterTest extends \PHPUnit_Framework_TestCase {
    private $credentialsAdapterMock;
    private $credentialsMock;
    private $driver;
    private $hostName;
    private $credentials;
    private $data;
    private $dataWithCredentials;
    private $adapter;
    private $credentialsAdapterHelper;
    public function setUp() {
        $this->credentialsAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Adapters\CredentialsAdapter');
        $this->credentialsMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Credentials');

        $this->driver = 'mysql';
        $this->hostName = '127.0.0.1';

        $this->credentials = [
            'username' => 'roger',
            'password' => 'cyr'
        ];

        $this->data = [
            'driver' => $this->driver,
            'hostname' => $this->hostName
        ];

        $this->dataWithCredentials = [
            'driver' => $this->driver,
            'hostname' => $this->hostName,
            'credentials' => $this->credentials
        ];

        $this->adapter = new ConcreteRelationalDatabaseAdapter($this->credentialsAdapterMock);

        $this->credentialsAdapterHelper = new CredentialsAdapterHelper($this, $this->credentialsAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToRelationalDatabase_Success() {

        $relationalDatabase = $this->adapter->fromDataToRelationalDatabase($this->data);

        $this->assertEquals($this->driver, $relationalDatabase->getDriver());
        $this->assertEquals($this->hostName, $relationalDatabase->getHostName());
        $this->assertFalse($relationalDatabase->hasCredentials());
        $this->assertNull($relationalDatabase->getCredentials());

    }

    public function testFromDataToRelationalDatabase_withCredentials_Success() {

        $this->credentialsAdapterHelper->expectsFromDataToCredentials_Success($this->credentialsMock, $this->credentials);

        $relationalDatabase = $this->adapter->fromDataToRelationalDatabase($this->dataWithCredentials);

        $this->assertEquals($this->driver, $relationalDatabase->getDriver());
        $this->assertEquals($this->hostName, $relationalDatabase->getHostName());
        $this->assertTrue($relationalDatabase->hasCredentials());
        $this->assertEquals($this->credentialsMock, $relationalDatabase->getCredentials());

    }

    public function testFromDataToRelationalDatabase_withCredentials_throwsCredentialsException_throwsRelationalDatabaseException() {

        $this->credentialsAdapterHelper->expectsFromDataToCredentials_throwsCredentialsException($this->credentials);

        $asserted = false;
        try {

            $this->adapter->fromDataToRelationalDatabase($this->dataWithCredentials);

        } catch (RelationalDatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRelationalDatabase_withoutDriver_throwsRelationalDatabaseException() {

        unset($this->data['driver']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRelationalDatabase($this->data);

        } catch (RelationalDatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRelationalDatabase_withoutHostname_throwsRelationalDatabaseException() {

        unset($this->data['hostname']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRelationalDatabase($this->data);

        } catch (RelationalDatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
