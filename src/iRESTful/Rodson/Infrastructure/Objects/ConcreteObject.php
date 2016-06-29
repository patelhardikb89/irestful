<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Objects\Object;
use iRESTful\Rodson\Domain\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\Domain\Databases\Database;

final class ConcreteObject implements Object {
    private $name;
    private $properties;
    private $database;
    public function __construct($name, array $properties, Database $database = null) {

        if (empty($name) || !is_string($name)) {
            throw new ObjectException('The name must be a non-empty string.');
        }

        if (empty($properties)) {
            throw new ObjectException('There must be at least 1 property.');
        }

        foreach($properties as $index => $oneProperty) {

            if (!is_integer($index)) {
                throw new ObjectException('The indexes of the properties array must be integers.');
            }

            if (!($oneProperty instanceof \iRESTful\Rodson\Domain\Objects\Properties\Property)) {
                throw new ObjectException('The properties array must only contain Property objects.');
            }

        }

        $this->name = $name;
        $this->properties = $properties;
        $this->database = $database;

    }

    public function getName() {
        return $this->name;
    }

    public function getProperties() {
        return $this->properties;
    }

    public function hasDatabase() {
        return !empty($this->database);
    }

    public function getDatabase() {
        return $this->database;
    }

}
