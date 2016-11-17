<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDOAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcretePDOAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class ConcretePDOAdapterFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
    private $timezone;
    private $driver;
    private $hostname;
    private $database;
    private $username;
    private $password;
    private $data;
    private $dataWithPassword;
    private $factory;
    private $factoryWithPassword;
    private $adapter;
    public function setUp() {

        \iRESTful\LeoPaul\Applications\Libraries\PDO\Installations\Database::reset();

        $this->timezone = 'America/Montreal';
        $this->driver = getenv('DB_DRIVER');
        $this->hostname = getenv('DB_SERVER');
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
        $this->database = getenv('DB_NAME');

        $this->data = [
            'timezone' => $this->timezone,
            'driver' => $this->driver,
            'hostname' => $this->hostname,
            'database' => $this->database,
            'username' => $this->username
        ];

        $this->dataWithPassword = [
            'timezone' => $this->timezone,
            'driver' => $this->driver,
            'hostname' => $this->hostname,
            'database' => $this->database,
            'username' => $this->username,
            'password' => $this->password
        ];

        $this->factoryWithPassword = new ConcretePDOAdapterFactory($this->timezone, $this->driver, $this->hostname, $this->database, $this->username, $this->password);
        $this->factory = new ConcretePDOAdapterFactory($this->timezone, $this->driver, $this->hostname, $this->database, $this->username);
        $this->adapter = new ConcretePDOAdapterFactoryAdapter();
    }

    public function tearDown() {

    }

    public function testFromDataToPDOAdapterFactory_Success() {

        $factory = $this->adapter->fromDataToPDOAdapterFactory($this->data);

        $this->assertEquals($this->factory, $factory);

    }

    public function testFromDataToPDOAdapterFactory_withPassword_Success() {

        $factory = $this->adapter->fromDataToPDOAdapterFactory($this->dataWithPassword);

        $this->assertEquals($this->factoryWithPassword, $factory);

    }

    public function testFromDataToPDOAdapterFactory_withoutTimezoneInData_throwsPDOException() {

        unset($this->data['timezone']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDOAdapterFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToPDOAdapterFactory_withoutDriverInData_throwsPDOException() {

        unset($this->data['driver']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDOAdapterFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToPDOAdapterFactory_withoutHostnameInData_throwsPDOException() {

        unset($this->data['hostname']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDOAdapterFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToPDOAdapterFactory_withoutDatabaseInData_throwsPDOException() {

        unset($this->data['database']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDOAdapterFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToPDOAdapterFactory_withoutUsernameInData_throwsPDOException() {

        unset($this->data['username']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDOAdapterFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
