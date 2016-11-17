<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Database;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Relationals\RelationalDatabase;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\RESTAPIs\RESTAPI;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Exceptions\DatabaseException;

final class ConcreteDatabase implements Database {
    private $name;
    private $relationalDatabase;
    private $restAPI;
    public function __construct(string $name, RelationalDatabase $relationalDatabase = null, RESTAPI $restAPI = null) {

        if (empty($name)) {
            throw new DatabaseException('The name must be a non-empty string.');
        }

        $amount = (empty($relationalDatabase) ? 0 : 1) + (empty($restAPI) ? 0 : 1);
        if ($amount != 1) {
            throw new DatabaseException('There must be either a relationalDatabase or a RESTAPI object.  '.$amount.' given.');
        }

        $this->name = $name;
        $this->relationalDatabase = $relationalDatabase;
        $this->restAPI = $restAPI;
    }

    public function getName(): string {
        return $this->name;
    }

    public function hasRelational(): bool {
        return !empty($this->relationalDatabase);
    }

    public function getRelational() {
        return $this->relationalDatabase;
    }

    public function hasRESTAPI(): bool {
        return !empty($this->restAPI);
    }

    public function getRESTAPI() {
        return $this->restAPI;
    }

}
