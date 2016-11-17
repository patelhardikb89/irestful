<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Type as PropertyType;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Primitives\Primitive;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Exceptions\TypeException;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Parents\ParentObject;

final class ConcreteObjectPropertyType implements PropertyType {
    private $isArray;
    private $primitive;
    private $type;
    private $object;
    private $parentObject;
    public function __construct(bool $isArray, Primitive $primitive = null, Type $type = null, Object $object = null, ParentObject $parentObject = null) {

        $amount = (empty($primitive) ? 0 : 1) +  (empty($type) ? 0 : 1) + (empty($object) ? 0 : 1) + (empty($parentObject) ? 0 : 1);
        if ($amount != 1) {
            throw new TypeException('The must be either a Primitive, Type, Object or ParentObject.  '.$amount.' given.');
        }

        $this->isArray = $isArray;
        $this->primitive = $primitive;
        $this->type = $type;
        $this->object = $object;
        $this->parentObject = $parentObject;
    }

    public function isArray(): bool {
        return $this->isArray;
    }

    public function hasPrimitive(): bool {
        return !empty($this->primitive);
    }

    public function getPrimitive() {
        return $this->primitive;
    }

    public function hasType(): bool {
        return !empty($this->type);
    }

    public function getType() {
        return $this->type;
    }

    public function hasObject(): bool {
        return !empty($this->object);
    }

    public function getObject() {
        return $this->object;
    }

    public function hasParentObject(): bool {
        return !empty($this->parentObject);
    }

    public function getParentObject() {
        return $this->parentObject;
    }

}
