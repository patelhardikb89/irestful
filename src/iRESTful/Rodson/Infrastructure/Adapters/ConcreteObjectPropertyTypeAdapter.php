<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Objects\Properties\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteObjectPropertyType;
use iRESTful\Rodson\Domain\Objects\Properties\Types\Exceptions\TypeException;

final class ConcreteObjectPropertyTypeAdapter implements TypeAdapter {
    private $types;
    private $objects;
    public function __construct(array $types, array $objects) {
        $this->types = $types;
        $this->objects = $objects;
    }

    public function fromStringToType($type) {

        $typePos = strrpos($type, '[]');
        $isArray = (($typePos + 2) == strlen($type));

        if ($isArray) {
            $type = substr($type, 0, $typePos);
        }

        if (isset($this->types[$type])) {
            return new ConcreteObjectPropertyType($isArray, $this->types[$type]);
        }

        if (isset($this->objects[$type])) {
            return new ConcreteObjectPropertyType($isArray, null, $this->objects[$type]);
        }

        throw new TypeException('The given type ('.$type.') does not reference a Type or an Object.');

    }

}
