<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Projects\Primitives\Primitive;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Types\Exceptions\TypeException;

final class ConcreteObjectPropertyType implements PropertyType {
    private $isArray;
    private $primitive;
    private $type;
    private $object;
    public function __construct($isArray, Primitive $primitive = null, Type $type = null, Object $object = null) {

        $amount = (empty($primitive) ? 0 : 1) +  (empty($type) ? 0 : 1) + (empty($object) ? 0 : 1);
        if ($amount != 1) {
            throw new TypeException('The must be either a Primitive, Type or an Object.  '.$amount.' given.');
        }

        $this->isArray = (bool) $isArray;
        $this->primitive = $primitive;
        $this->type = $type;
        $this->object = $object;
    }

    public function hasPrimitive() {
        return !empty($this->primitive);
    }

    public function getPrimitive() {
        return $this->primitive;
    }

    public function hasType() {
        return !empty($this->type);
    }

    public function getType() {
        return $this->type;
    }

    public function hasObject() {
        return !empty($this->object);
    }

    public function getObject() {
        return $this->object;
    }

    public function isArray() {
        return $this->isArray;
    }

}
