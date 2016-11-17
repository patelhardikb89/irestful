<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\NativePDO;

final class ConcreteNativePDO implements NativePDO {
    private $pdo;
    private $driver;
    private $hostName;
    private $username;
    private $database;
    public function __construct(\PDO $pdo, $driver, $hostName, $username, $database) {
        $this->pdo = $pdo;
        $this->driver = $driver;
        $this->hostName = $hostName;
        $this->username = $username;
        $this->database = $database;
    }

    public function getPDO() {
        return $this->pdo;
    }

    public function getDriver() {
        return $this->driver;
    }

    public function getHostName() {
        return $this->hostName;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getDatabase() {
        return $this->database;
    }

}
