<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Databases\Relationals\RelationalDatabase;
use iRESTful\Objects\Libraries\Credentials\Domain\Credentials;
use iRESTful\Rodson\Domain\Databases\Relationals\Exceptions\RelationDatabaseException;

final class ConcreteRelationDatabase implements RelationalDatabase {
    private $driver;
    private $hostName;
    private $credentials;
    public function __construct($driver, $hostName, Credentials $credentials) {

        if (empty($driver) && !is_string($driver)) {
            throw new RelationDatabaseException('The driver must be a non-empty string.');
        }

        if (empty($hostName) && !is_string($hostName)) {
            throw new RelationDatabaseException('The hostName must be a non-empty string.');
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

    public function getCredentials() {
        return $this->credentials;
    }

}
