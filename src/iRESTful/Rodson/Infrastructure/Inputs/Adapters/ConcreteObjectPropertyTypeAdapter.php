<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteObjectPropertyType;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Types\Exceptions\TypeException;

final class ConcreteObjectPropertyTypeAdapter implements TypeAdapter {
    private $types;
    private $primitives;
    private $objects;
    public function __construct(array $types, array $primitives, array $objects) {
        $this->types = $types;
        $this->primitives = $primitives;
        $this->objects = $objects;
    }

    public function fromStringToType($type) {

        $typePos = strrpos($type, '[]');
        $isArray = (($typePos + 2) == strlen($type));

        if ($isArray) {
            $type = substr($type, 0, $typePos);
        }

        if (isset($this->types[$type])) {
            return new ConcreteObjectPropertyType($isArray, null, $this->types[$type]);
        }

        if (isset($this->objects[$type])) {
            return new ConcreteObjectPropertyType($isArray, null, null, $this->objects[$type]);
        }

        if (isset($this->primitives[$type])) {
            return new ConcreteObjectPropertyType($isArray, $this->primitives[$type]);
        }

        throw new TypeException('The given type ('.$type.') does not reference a Primitive, Type or an Object.');
    }

}
