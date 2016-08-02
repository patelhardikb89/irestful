<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Adapters\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Domain\Inputs\Primitives\Primitive;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteAdapterType;

final class ConcreteAdapterTypeAdapter implements TypeAdapter {

    public function __construct() {

    }

    public function fromTypeToAdapterType(Type $type) {
        return new ConcreteAdapterType(null, $type);
    }

    public function fromPrimitiveToAdapterType(Primitive $primitive) {
        return new ConcreteAdapterType($primitive);
    }

}
