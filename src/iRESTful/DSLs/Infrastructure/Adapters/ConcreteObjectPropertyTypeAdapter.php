<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Adapters\TypeAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteObjectPropertyType;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Exceptions\TypeException;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Parents\Adapters\ParentObjectAdapter;

final class ConcreteObjectPropertyTypeAdapter implements TypeAdapter {
    private $parentObjectAdapter;
    private $types;
    private $primitives;
    private $objects;
    public function __construct(ParentObjectAdapter $parentObjectAdapter, array $types, array $primitives, array $objects) {
        $this->parentObjectAdapter = $parentObjectAdapter;
        $this->types = $types;
        $this->primitives = $primitives;
        $this->objects = $objects;
    }

    public function fromDataToType(array $data) {

        if (!isset($data['name'])) {
            throw new TypeException('The name is mandatory in order to convert data to a Type object.');
        }

        $parents = null;
        if (isset($data['parents'])) {
            $parents = $data['parents'];
        }

        $typeName = $data['name'];
        $pos = strrpos($typeName, '[]');
        $isArray = (($pos + 2) == strlen($typeName));

        if ($isArray) {
            $typeName = substr($typeName, 0, $pos);
        }

        if (isset($this->types[$typeName])) {
            return new ConcreteObjectPropertyType($isArray, null, $this->types[$typeName]);
        }

        if (isset($this->objects[$typeName])) {
            return new ConcreteObjectPropertyType($isArray, null, null, $this->objects[$typeName]);
        }

        if (isset($this->primitives[$typeName])) {
            return new ConcreteObjectPropertyType($isArray, $this->primitives[$typeName]);
        }

        if (strpos($typeName, '->') !== false) {
            $exploded = explode('->', $typeName);
            $parentDSLName = $exploded[0];

            if (!isset($parents[$parentDSLName])) {
                throw new TypeException('There is a type ('.$typeName.') that reference an invalid parent DSL ('.$parentDSLName.').');
            }

            $parentObject = $this->parentObjectAdapter->fromDataToParentObject([
                'sub_dsl' => $parents[$parentDSLName],
                'name' => $exploded[1]
            ]);

            return new ConcreteObjectPropertyType($isArray, null, null, null, $parentObject);
        }

        throw new TypeException('The given type ('.$typeName.') does not reference a Primitive, Type, Object or ParentObject.');

    }

}
