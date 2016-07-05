<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Exceptions\TypeException;

final class ConcreteObjectPropertyType implements PropertyType {
    private $isArray;
    private $type;
    private $object;
    public function __construct($isArray, Type $type = null, Object $object = null) {

        $amount = (empty($type) ? 0 : 1) + (empty($object) ? 0 : 1);
        if ($amount != 1) {
            throw new TypeException('The must be either a Type or an Object.  '.$amount.' given.');
        }

        $this->isArray = (bool) $isArray;
        $this->type = $type;
        $this->object = $object;
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
