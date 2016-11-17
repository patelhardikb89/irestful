<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDORepositoryFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcretePDORepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class ConcretePDORepositoryFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
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

        $this->factoryWithPassword = new ConcretePDORepositoryFactory($this->timezone, $this->driver, $this->hostname, $this->database, $this->username, $this->password);
        $this->factory = new ConcretePDORepositoryFactory($this->timezone, $this->driver, $this->hostname, $this->database, $this->username);
        $this->adapter = new ConcretePDORepositoryFactoryAdapter();
    }

    public function tearDown() {

    }

    public function testFromDataToPDORepositoryFactory_Success() {

        $factory = $this->adapter->fromDataToPDORepositoryFactory($this->data);

        $this->assertEquals($this->factory, $factory);

    }

    public function testFromDataToPDORepositoryFactory_withPassword_Success() {

        $factory = $this->adapter->fromDataToPDORepositoryFactory($this->dataWithPassword);

        $this->assertEquals($this->factoryWithPassword, $factory);

    }

    public function testFromDataToPDORepositoryFactory_withoutTimezoneInData_throwsPDOException() {

        unset($this->data['timezone']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDORepositoryFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToPDORepositoryFactory_withoutDriverInData_throwsPDOException() {

        unset($this->data['driver']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDORepositoryFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToPDORepositoryFactory_withoutHostnameInData_throwsPDOException() {

        unset($this->data['hostname']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDORepositoryFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToPDORepositoryFactory_withoutDatabaseInData_throwsPDOException() {

        unset($this->data['database']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDORepositoryFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToPDORepositoryFactory_withoutUsernameInData_throwsPDOException() {

        unset($this->data['username']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDORepositoryFactory($this->data);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
