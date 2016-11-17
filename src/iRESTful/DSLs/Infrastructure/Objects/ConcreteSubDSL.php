<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\SubDSLs\SubDSL;
use iRESTful\DSLs\Domain\Projects\Databases\Database;
use iRESTful\DSLs\Domain\DSL;

final class ConcreteSubDSL implements SubDSL {
    private $name;
    private $database;
    private $dsl;
    public function __construct(string $name, Database $database, DSL $dsl) {
        $this->name = $name;
        $this->database = $database;
        $this->dsl = $dsl;
    }

    public function getName() {
        return $this->name;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getDSL() {
        return $this->dsl;
    }

}
