<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Entities\Entity;
use iRESTful\Rodson\Domain\Databases\Database;
use iRESTful\Rodson\Domain\Entities\Exceptions\EntityException;

final class ConcreteEntity implements Entity {
    private $name;
    private $properties;
    private $database;
    public function __construct($name, array $properties, Database $database) {

        if (empty($name) || !is_string($name)) {
            throw new EntityException('The name must be a non-empty string.');
        }

        if (empty($properties)) {
            throw new EntityException('There must be at least 1 property.');
        }

        foreach($properties as $index => $oneProperty) {

            if (!is_integer($index)) {
                throw new EntityException('The indexes of the properties array must be integers.');
            }

            if (!($oneProperty instanceof \iRESTful\Rodson\Domain\Entities\Properties\Property)) {
                throw new EntityException('The properties array must only contain Property objects.');
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

    public function getDatabase() {
        return $this->database;
    }

}
