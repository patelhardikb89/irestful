<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Exceptions\PropertyException;

final class ConcreteObjectProperty implements Property {
    private $name;
    private $type;
    private $isOptional;
    public function __construct($name, Type $type, $isOptional) {

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

}
