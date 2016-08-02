<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Exceptions\PropertyException;

final class ConcreteObjectProperty implements Property {
    private $name;
    private $type;
    private $isOptional;
    private $isUnique;
    private $isKey;
    private $default;
    public function __construct($name, Type $type, $isOptional, $isUnique, $isKey, $default = null) {

        if (empty($name) || !is_string($name)) {
            throw new PropertyException('The name must be a non-empty string.');
        }

        $matches = [];
        preg_match_all('/[a-z\_]+/s', $name, $matches);
        if (!isset($matches[0][0]) || ($matches[0][0] != $name)) {
            throw new PropertyException('The name ('.$name.') must only contain lowercase letters (a-z) and underscores (_).');
        }

        $this->name = $name;
        $this->type = $type;
        $this->isOptional = (boolean) $isOptional;
        $this->isUnique = (boolean) $isUnique;
        $this->isKey = (boolean) $isKey;
        $this->default = $default;

    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function isOptional() {
        return $this->isOptional;
    }

    public function isUnique() {
        return $this->isUnique;
    }

    public function isKey() {
        return $this->isKey;
    }

    public function hasDefault() {
        return !is_null($this->default);
    }

    public function getDefault() {
        return $this->default;
    }

}
