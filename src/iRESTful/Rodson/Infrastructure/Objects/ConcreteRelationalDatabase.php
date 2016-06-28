<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Databases\Relationals\RelationalDatabase;
use iRESTful\Objects\Libraries\Credentials\Domain\Credentials;
use iRESTful\Rodson\Domain\Databases\Relationals\Exceptions\RelationalDatabaseException;

final class ConcreteRelationalDatabase implements RelationalDatabase {
    private $driver;
    private $hostName;
    private $credentials;
    public function __construct($driver, $hostName, Credentials $credentials = null) {

        if (empty($driver) || !is_string($driver)) {
            throw new RelationalDatabaseException('The driver must be a non-empty string.');
        }

        if (empty($hostName) || !is_string($hostName)) {
            throw new RelationalDatabaseException('The hostName must be a non-empty string.');
        }

        $this->driver = $driver;
        $this->hostName = $hostName;
        $this->credentials = $credentials;

    }

    public function getDriver() {
        return $this->driver;
    }

    public function getHostName() {
        return $this->hostName;
    }

    public function hasCredentials() {
        return !empty($this->credentials);
    }

    public function getCredentials() {
        return $this->credentials;
    }

}
