<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Database;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Methods\Method;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Samples\Sample;

final class ConcreteObject implements Object {
    private $name;
    private $properties;
    private $database;
    private $methods;
    public function __construct(string $name, array $properties, Database $database = null, array $methods = null) {

        if (empty($methods)) {
            $methods = null;
        }

        if (empty($name)) {
            throw new ObjectException('The name must be a non-empty string.');
        }

        if (empty($properties)) {
            throw new ObjectException('There must be at least 1 property.');
        }

        foreach($properties as $index => $oneProperty) {
            if (!($oneProperty instanceof \iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property)) {
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
        $this->properties = array_values($properties);
        $this->database = $database;
        $this->methods = (empty($methods)) ? null : array_values($methods);

    }

    public function getName(): string {
        return $this->name;
    }

    public function getProperties(): array {
        return $this->properties;
    }

    public function hasDatabase(): bool {
        return !empty($this->database);
    }

    public function getDatabase() {
        return $this->database;
    }

    public function hasMethods(): bool {
        return !empty($this->methods);
    }

    public function getMethods() {
        return $this->methods;
    }

    public function getPropertyTypes() {
        $types = [];
        $properties = $this->getProperties();
        foreach($properties as $oneProperty) {
            $types[] = $oneProperty->getType();
        }

        return $types;
    }

    public function getTypes() {
        $types = [];
        $propertyTypes = $this->getPropertyTypes();
        foreach($propertyTypes as $onePropertyType) {
            if ($onePropertyType->hasType()) {
                $types[] = $onePropertyType->getType();
            }
        }

        return $types;
    }

}
