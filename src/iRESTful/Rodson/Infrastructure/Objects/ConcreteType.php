<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Types\Type;
use iRESTful\Rodson\Domain\Types\Exceptions\TypeException;
use iRESTful\Rodson\Domain\Types\Databases\DatabaseType;
use iRESTful\Rodson\Domain\Adapters\Adapter;
use iRESTful\Rodson\Domain\Codes\Code;

final class ConcreteType implements Type {
    private $name;
    private $databaseType;
    private $databaseAdapter;
    private $viewAdapter;
    private $code;
    public function __construct($name, DatabaseType $databaseType, Adapter $databaseAdapter = null, Adapter $viewAdapter = null, Code $code = null) {

        if (empty($name) || !is_string($name)) {
            throw new TypeException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->databaseType = $databaseType;
        $this->databaseAdapter = $databaseAdapter;
        $this->viewAdapter = $viewAdapter;
        $this->code = $code;
    }

    public function getName() {
        return $this->name;
    }

    public function getDatabaseType() {
        return $this->databaseType;
    }

    public function hasDatabaseAdapter() {
        return !empty($this->databaseAdapter);
    }

    public function getDatabaseAdapter() {
        return $this->databaseAdapter;
    }

    public function hasViewAdapter() {
        return !empty($this->viewAdapter);
    }

    public function getViewAdapter() {
        return $this->viewAdapter;
    }

    public function hasCode() {
        return !empty($this->code);
    }

    public function getCode() {
        return $this->code;
    }

}
