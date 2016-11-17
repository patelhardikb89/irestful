<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Server;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Client;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Exceptions\ServerException;

final class ConcreteServer implements Server {
    private $client;
    private $driver;
    private $hostName;
    private $database;
    private $username;
    private $stats;
    private $version;
    private $isPersistent;
    private $isAutoCommit;
    public function __construct(Client $client, $driver, $hostName, $database, $username, $stats, $version, $isPersistent, $isAutoCommit) {

        $isPersistent = (bool) $isPersistent;
        $isAutoCommit = (bool) $isAutoCommit;

        if (empty($version) || !is_string($version)) {
            throw new ServerException('The version must be a non-empty string.');
        }

        if (empty($stats) || !is_string($stats)) {
            throw new ServerException('The stats must be a non-empty string.');
        }

        if (empty($username) || !is_string($username)) {
            throw new ServerException('The username must be a non-empty string.');
        }

        if (empty($database) || !is_string($database)) {
            throw new ServerException('The database must be a non-empty string.');
        }

        if (empty($hostName) || !is_string($hostName)) {
            throw new ServerException('The hostName must be a non-empty string.');
        }

        if (empty($driver) || !is_string($driver)) {
            throw new ServerException('The driver must be a non-empty string.');
        }

        $this->client = $client;
        $this->driver = $driver;
        $this->hostName = $hostName;
        $this->database = $database;
        $this->username = $username;
        $this->stats = $stats;
        $this->version = $version;
        $this->isPersistent = $isPersistent;
        $this->isAutoCommit = $isAutoCommit;

    }

    public function getClient() {
        return $this->client;
    }

    public function getDriver() {
        return $this->driver;
    }

    public function getHostname() {
        return $this->hostName;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getStats() {
        return $this->stats;
    }

    public function getVersion() {
        return $this->version;
    }

    public function isPersistent() {
        return $this->isPersistent;
    }

    public function isAutoCommit() {
        return $this->isAutoCommit;
    }

}
