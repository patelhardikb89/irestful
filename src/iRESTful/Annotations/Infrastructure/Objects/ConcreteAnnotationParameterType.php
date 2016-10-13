<?php
namespace iRESTful\Annotations\Infrastructure\Objects;
use iRESTful\Annotations\Domain\Parameters\Types\Type;
use iRESTful\DSLs\Domain\Projects\Types\Databases\DatabaseType;

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

    public function getData() {

        $output = [
            'is_unique' => $this->isUnique(),
            'is_key' => $this->isKey(),
            'database_type' => $this->getDatabaseType()->getData()
        ];

        if ($this->hasDefault()) {
            $output['default'] = $this->getDefault();
        }

        return $output;
    }

}
