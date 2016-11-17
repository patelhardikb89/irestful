<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\Factories\NativePDOFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects\ConcreteNativePDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\Exceptions\NativePDOException;

final class ConcreteNativePDOFactory implements NativePDOFactory {
    private $driver;
    private $hostName;
    private $database;
    private $username;
    private $password;
    private $cache;
    public function __construct($driver, $hostName, $database, $username, $password = null) {

        if (empty($password)) {
            $password = null;
        }

        $this->driver = $driver;
        $this->hostName = $hostName;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->cache = null;

    }

    public function create() {

        if (!empty($this->cache)) {
            return $this->cache;
        }

        try {

            $dsn = $this->driver.':host='.$this->hostName;
            $pdo = (empty($this->password)) ? new \PDO($dsn, $this->username) : new \PDO($dsn, $this->username, $this->password);
            $statement = $pdo->prepare('use '.$this->database);
            if (!$statement->execute()) {
                throw new NativePDOException('There was a problem while selecting the "'.$this->database.'" database.  Are you sure it exists?');
            }

            $this->cache = new ConcreteNativePDO($pdo, $this->driver, $this->hostName, $this->username, $this->database);
            return $this->cache;

        } catch (\PDOException $exception) {
            throw new NativePDOException('There was an exception while using the native \PDO object.', $exception);
        }
    }

}
