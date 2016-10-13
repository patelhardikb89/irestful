<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Objects\Exceptions\ObjectException;
use iRESTful\DSLs\Domain\Projects\Databases\Database;
use iRESTful\DSLs\Domain\Projects\Objects\Methods\Method;
use iRESTful\DSLs\Domain\Projects\Objects\Samples\Sample;

final class ConcreteObject implements Object {
    private $name;
    private $properties;
    private $database;
    private $methods;
    private $samples;
    public function __construct(string $name, array $properties, Database $database = null, array $methods = null, array $samples = null) {

        if (empty($methods)) {
            $methods = null;
        }

        if (empty($samples)) {
            $samples = null;
        }

        if (empty($name)) {
            throw new ObjectException('The name must be a non-empty string.');
        }

        if (empty($properties)) {
            throw new ObjectException('There must be at least 1 property.');
        }

        if (empty($samples) && !empty($database)) {
            throw new ObjectException('The object ('.$name.') contains a database, but no samples.  Every object that contains a database must also contain samples.');
        }

        if (empty($database) && !empty($samples)) {
            throw new ObjectException('The object ('.$name.') contains a samples, but no database.  Every object that contains samples must also contain a database.');
        }

        foreach($properties as $index => $oneProperty) {
            if (!($oneProperty instanceof \iRESTful\DSLs\Domain\Projects\Objects\Properties\Property)) {
                throw new ObjectException('The properties array must only contain Property objects.');
            }

        }

        if (!empty($samples)) {
            foreach($samples as $oneSample) {
                if (!($oneSample instanceof Sample)) {
                    throw new ObjectException('The samples array must only contain Sample objects.');
                }
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
        $this->samples = (empty($samples)) ? null : array_values($samples);

    }

    public function getName(): string {
        return $this->name;
    }

    public function getProperties(): array {
        return $this->properties;
    }

    public function hasSamples(): bool {
        return !empty($this->samples);
    }

    public function getSamples() {
        return $this->samples;
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

    public function getTypes() {
        $types = [];
        $properties = $this->getProperties();
        foreach($properties as $oneProperty) {
            $propertyType = $oneProperty->getType();
            if ($propertyType->hasType()) {
                $types[] = $propertyType->getType();
            }
        }

        return $types;
    }

}
