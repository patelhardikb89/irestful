<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\Domain\Inputs\Databases\Database;
use iRESTful\Rodson\Domain\Inputs\Objects\Methods\Method;
use iRESTful\Rodson\Domain\Inputs\Objects\Samples\Sample;

final class ConcreteObject implements Object {
    private $name;
    private $properties;
    private $database;
    private $methods;
    private $samples;
    public function __construct($name, array $properties, Database $database = null, array $methods = null, array $samples = null) {

        if (empty($methods)) {
            $methods = null;
        }

        if (empty($samples)) {
            $samples = null;
        }

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

        if (!empty($samples)) {
            foreach($samples as $oneSample) {
                if (!($oneSample instanceof Sample)) {
                    throw new ObjectException('The samples array must only contain Sample objects.');
                }
            }
        }

        $this->name = $name;
        $this->properties = $properties;
        $this->database = $database;
        $this->methods = $methods;
        $this->samples = $samples;

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

    public function hasSamples() {
        return !empty($this->samples);
    }

    public function getSamples() {
        return $this->samples;
    }

}
