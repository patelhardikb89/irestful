<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Converters\Types\Type as ConverterType;
use iRESTful\DSLs\Domain\Projects\Primitives\Primitive;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\DSLs\Domain\Projects\Converters\Types\Exceptions\TypeException;

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

    public function hasType(): bool {
        return !empty($this->type);
    }

    public function getType() {
        return $this->type;
    }

    public function hasPrimitive(): bool {
        return !empty($this->primitive);
    }

    public function getPrimitive() {
        return $this->primitive;
    }

}
