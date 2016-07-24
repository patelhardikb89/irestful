<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\Domain\Inputs\Databases\Database;
use iRESTful\Rodson\Domain\Inputs\Objects\Methods\Method;

final class ConcreteObject implements Object {
    private $name;
    private $properties;
    private $database;
    private $methods;
    public function __construct($name, array $properties, Database $database = null, array $methods = null) {

        if (empty($name) || !is_string($name)) {
            throw new ObjectException('The name must be a non-empty string.');
        }

        if (empty($properties)) {
            throw new ObjectException('There must be at least 1 property.');
        }

        if (empty($methods)) {
            $methods = null;
        }

        foreach($properties as $index => $oneProperty) {

            if (!is_integer($index)) {
                throw new ObjectException('The indexes of the properties array must be integers.');
            }

            if (!($oneProperty instanceof \iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property)) {
                throw new ObjectException('The properties array must only contain Property objects.');
            }

        }

        if (!empty($methods)) {
            foreach($methods as $oneMethod) {
                if (!($oneMethod instanceof Method)) {
                    throw new ObjectException('The methods array must only contain Method objects.');
                }
            }
        }

        $this->name = $name;
        $this->properties = $properties;
        $this->database = $database;
        $this->methods = $methods;

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

    public function hasMethods() {
        return !empty($this->methods);
    }

    public function getMethods() {
        return $this->methods;
    }

}
