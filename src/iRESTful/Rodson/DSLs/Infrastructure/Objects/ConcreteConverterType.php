<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Type as ConverterType;
use iRESTful\Rodson\DSLs\Domain\Projects\Primitives\Primitive;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Exceptions\TypeException;

final class ConcreteConverterType implements ConverterType {
    private $isData;
    private $primitive;
    private $type;
    private $objectReferenceName;
    public function __construct(bool $isData, Primitive $primitive = null, Type $type = null, string $objectReferenceName = null) {

        $amount = ($isData ? 1 : 0) + (empty($primitive) ? 0 : 1) + (empty($type) ? 0 : 1) + (empty($objectReferenceName) ? 0 : 1);
        if ($amount != 1) {
            throw new TypeException('There must be either a primitive or a type.  '.$amount.' given.');
        }

        $this->primitive = $primitive;
        $this->type = $type;
        $this->isData = $isData;
        $this->objectReferenceName = $objectReferenceName;

    }

    public function isData(): bool {
        return $this->isData;
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

    public function hasObjectReferenceName() {
        return !empty($this->objectReferenceName);
    }

    public function getObjectReferenceName() {
        return $this->objectReferenceName;
    }

}
