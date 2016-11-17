<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Functional\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcretePDOServiceFactory;

final class ConcretePDOServiceFactoryTest extends \PHPUnit_Framework_TestCase {
    private $timeZone;
    private $driver;
    private $hostName;
    private $database;
    private $username;
    private $password;
    private $factory;
    private $factoryWithInvalidTimezone;
    public function setUp() {

        \iRESTful\LeoPaul\Applications\Libraries\PDO\Installations\Database::reset();

        $this->timeZone = 'America/Montreal';
        $this->driver = getenv('DB_DRIVER');
        $this->hostName = getenv('DB_SERVER');
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
        $this->database = getenv('DB_NAME');

        $this->factory = new ConcretePDOServiceFactory($this->timeZone, $this->driver, $this->hostName, $this->database, $this->username, $this->password);
        $this->factoryWithInvalidTimezone = new ConcretePDOServiceFactory('invalid timezone', $this->driver, $this->hostName, $this->database, $this->username, $this->password);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $pdoService = $this->factory->create();

        $this->assertTrue($pdoService instanceof \iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\PDOService);

    }

}
