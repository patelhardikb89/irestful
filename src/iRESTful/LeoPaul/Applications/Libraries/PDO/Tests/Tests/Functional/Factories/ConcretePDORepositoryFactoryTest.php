<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Functional\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcretePDORepositoryFactory;

final class ConcretePDORepositoryFactoryTest extends \PHPUnit_Framework_TestCase {
    private $timeZone;
    private $driver;
    private $hostName;
    private $database;
    private $username;
    private $password;
    private $factory;
    public function setUp() {

        \iRESTful\LeoPaul\Applications\Libraries\PDO\Installations\Database::reset();

        $this->timeZone = 'America/Montreal';
        $this->driver = getenv('DB_DRIVER');
        $this->hostName = getenv('DB_SERVER');
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
        $this->database = getenv('DB_NAME');

        $this->factory = new ConcretePDORepositoryFactory($this->timeZone, $this->driver, $this->hostName, $this->database, $this->username, $this->password);
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $pdoRepository = $this->factory->create();

        $this->assertTrue($pdoRepository instanceof \iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository);

    }

}
