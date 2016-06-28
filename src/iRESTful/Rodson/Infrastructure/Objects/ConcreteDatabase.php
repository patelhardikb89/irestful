<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Databases\Database;
use iRESTful\Rodson\Domain\Databases\Relationals\RelationalDatabase;
use iRESTful\Rodson\Domain\Databases\RESTAPIs\RESTAPI;
use iRESTful\Rodson\Domain\Databases\Exceptions\DatabaseException;

final class ConcreteDatabase implements Database {
    private $relationalDatabase;
    private $restAPI;
    public function __construct(RelationalDatabase $relationalDatabase = null, RESTAPI $restAPI = null) {

        $amount = (empty($relationalDatabase) ? 0 : 1) + (empty($restAPI) ? 0 : 1);
        if ($amount != 1) {
            throw new DatabaseException('There must be either a relationalDatabase or a RESTAPI object.  '.$amount.' given.');
        }

        $this->relationalDatabase = $relationalDatabase;
        $this->restAPI = $restAPI;
    }

    public function hasRelational() {
        return !empty($this->relationalDatabase);
    }

    public function getRelational() {
        return $this->relationalDatabase;
    }

    public function hasRESTAPI() {
        return !empty($this->restAPI);
    }

    public function getRESTAPI() {
        return $this->restAPI;
    }

}
