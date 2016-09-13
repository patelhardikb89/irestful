<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Types\Type as ConverterType;
use iRESTful\Rodson\Domain\Inputs\Projects\Primitives\Primitive;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Types\Exceptions\TypeException;

final class ConcreteConverterType implements ConverterType {
    private $primitive;
    private $type;
    public function __construct(Primitive $primitive = null, Type $type = null) {

        $amount = (empty($primitive) ? 0 : 1) + (empty($type) ? 0 : 1);
        if ($amount != 1) {
            throw new TypeException('There must be either a primitive or a type.  '.$amount.' given.');
        }

        $this->primitive = $primitive;
        $this->type = $type;

    }

    public function hasType() {
        return !empty($this->type);
    }

    public function getType() {
        return $this->type;
    }

    public function hasPrimitive() {
        return !empty($this->primitive);
    }

    public function getPrimitive() {
        return $this->primitive;
    }

}
