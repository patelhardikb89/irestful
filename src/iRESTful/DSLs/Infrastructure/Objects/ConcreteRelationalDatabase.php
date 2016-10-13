<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Databases\Relationals\RelationalDatabase;
use iRESTful\DSLs\Domain\Projects\Databases\Credentials\Credentials;
use iRESTful\DSLs\Domain\Projects\Databases\Relationals\Exceptions\RelationalDatabaseException;

final class ConcreteRelationalDatabase implements RelationalDatabase {
    private $driver;
    private $hostName;
    private $engine;
    private $credentials;
    public function __construct(string $driver, string $hostName, string $engine, Credentials $credentials = null) {

        if (empty($driver)) {
            throw new RelationalDatabaseException('The driver must be a non-empty string.');
        }

        if (empty($hostName)) {
            throw new RelationalDatabaseException('The hostName must be a non-empty string.');
        }

        if (empty($engine)) {
            throw new RelationalDatabaseException('The engine must be a non-empty string.');
        }

        $this->driver = $driver;
        $this->hostName = $hostName;
        $this->engine = $engine;
        $this->credentials = $credentials;

    }

    public function getDriver(): string {
        return $this->driver;
    }

    public function getHostName(): string {
        return $this->hostName;
    }

    public function getEngine(): string {
        return $this->engine;
    }

    public function hasCredentials(): bool {
        return !empty($this->credentials);
    }

    public function getCredentials() {
        return $this->credentials;
    }

}
