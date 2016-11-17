<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcretePDOAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class ConcretePDOAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $timeZone;
    private $driver;
    private $hostName;
    private $database;
    private $username;
    private $password;
    private $factory;
    private $factoryWithPassword;
    private $factoryWithInvalidTimezone;
    public function setUp() {
        $this->timeZone = 'America/Montreal';
        $this->driver = getenv('DB_DRIVER');
        $this->hostName = getenv('DB_SERVER');
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
        $this->database = getenv('DB_NAME');

        $this->factory = new ConcretePDOAdapterFactory($this->timeZone, $this->driver, $this->hostName, $this->database, $this->username);
        $this->factoryWithPassword = new ConcretePDOAdapterFactory($this->timeZone, $this->driver, $this->hostName, $this->database, $this->username, $this->password);
        $this->factoryWithInvalidTimezone = new ConcretePDOAdapterFactory('invalid timezone', $this->driver, $this->hostName, $this->database, $this->username);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $pdoAdapter = $this->factory->create();

        $this->assertTrue($pdoAdapter instanceof \iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\PDOAdapter);

    }

    public function testCreate_withPassword_Success() {

        $pdoAdapter = $this->factoryWithPassword->create();

        $this->assertTrue($pdoAdapter instanceof \iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\PDOAdapter);

    }

    public function testCreate_withInvalidTimeZone_throwsDateTimeException_throwsPDOException() {

        $asserted = false;
        try {

            $this->factoryWithInvalidTimezone->create();

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
