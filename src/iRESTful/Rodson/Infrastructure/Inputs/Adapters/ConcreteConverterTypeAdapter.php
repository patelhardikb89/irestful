<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Primitives\Primitive;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteConverterType;

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
