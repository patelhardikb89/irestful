<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Converters\Types\Adapters\TypeAdapter;
use iRESTful\DSLs\Domain\Projects\Primitives\Primitive;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteConverterType;

final class ConcreteConverterTypeAdapter implements TypeAdapter {

    public function __construct() {

    }

    public function fromTypeToAdapterType(Type $type) {
        return new ConcreteConverterType(null, $type);
    }

    public function fromPrimitiveToAdapterType(Primitive $primitive) {
        return new ConcreteConverterType($primitive);
    }

}
