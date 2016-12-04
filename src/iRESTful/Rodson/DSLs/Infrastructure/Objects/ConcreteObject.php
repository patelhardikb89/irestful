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
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Converter;

final class ConcreteObject implements Object {
    private $name;
    private $properties;
    private $database;
    private $combos;
    private $converters;
    public function __construct(string $name, array $properties, Database $database = null, array $combos = null, array $converters = null) {

        if (empty($combos)) {
            $combos = null;
        }

        if (empty($converters)) {
            $converters = null;
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

        if (!empty($combos)) {
            foreach($combos as $oneCombo) {
                if (!($oneCombo instanceof Combo)) {
                    throw new ObjectException('The combos array must only contain Combo objects.');
                }
            }
        }

        if (!empty($converters)) {
            foreach($converters as $oneConverter) {
                if (!($oneConverter instanceof Converter)) {
                    throw new ObjectException('The converters array must only contain Converter objects.');
                }
            }
        }

        $this->name = $name;
        $this->properties = array_values($properties);
        $this->database = $database;
        $this->combos = $combos;
        $this->converters = $converters;

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

    public function hasCombos() {
        return !empty($this->combos);
    }

    public function getCombos() {
        return $this->combos;
    }

    public function hasConverters() {
        return !empty($this->converters);
    }

    public function getConverters() {
        return $this->converters;
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

    public function getObjectByPropertyByName(string $name) {
        $properties = $this->getProperties();
        foreach($properties as $oneProperty) {
            if ($oneProperty->getName() == $name) {
                $type = $oneProperty->getType();
                if (!$type->hasObject()) {
                    return null;
                }

                return $type->getObject();
            }
        }

        return null;
    }

}
