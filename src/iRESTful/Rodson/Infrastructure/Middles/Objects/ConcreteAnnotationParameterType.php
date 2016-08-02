<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\DatabaseType;

final class ConcreteAnnotationParameterType implements Type {
    private $isUnique;
    private $isKey;
    private $databaseType;
    private $default;
    public function __construct($isUnique, $isKey, DatabaseType $databaseType, $default = null) {
        $this->isUnique = (bool) $isUnique;
        $this->isKey = (bool) $isKey;
        $this->databaseType = $databaseType;
        $this->default = $default;
    }

    public function isUnique() {
        return $this->isUnique;
    }

    public function isKey() {
        return $this->isKey;
    }

    public function getDatabaseType() {
        return $this->databaseType;
    }

    public function hasDefault() {
        return !is_null($this->default);
    }

    public function getDefault() {
        return $this->default;
    }

}
