<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Primitives\Primitive;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;

interface TypeAdapter {
    public function fromTypeToAdapterType(Type $type);
    public function fromPrimitiveToAdapterType(Primitive $primitive);
}
