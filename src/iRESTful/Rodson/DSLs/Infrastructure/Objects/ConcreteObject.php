<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Database;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Methods\Method;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Samples\Sample;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Combo;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property;

final class ConcreteObject implements Object {
    private $name;
    private $properties;
    private $database;
    private $methods;
    private $combos;
    public function __construct(string $name, array $properties, Database $database = null, array $methods = null, array $combos = null) {

        if (empty($methods)) {
            $methods = null;
        }

        if (empty($combos)) {
            $combos = null;
        }

        if (empty($name)) {
            throw new ObjectException('The name must be a non-empty string.');
        }

        if (empty($properties)) {
            throw new ObjectException('There must be at least 1 property.');
        }

        foreach($properties as $index => $oneProperty) {
            if (!($oneProperty instanceof Property)) {
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

        if (!empty($combos)) {
            foreach($combos as $oneCombo) {
                if (!($oneCombo instanceof Combo)) {
                    throw new ObjectException('The combos array must only contain Combo objects.');
                }
            }
        }

        $this->name = $name;
        $this->properties = array_values($properties);
        $this->database = $database;
        $this->methods = (empty($methods)) ? null : array_values($methods);
        $this->combos = $combos;

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

    public function hasCombos() {
        return !empty($this->combos);
    }

    public function getCombos() {
        return $this->combos;
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
