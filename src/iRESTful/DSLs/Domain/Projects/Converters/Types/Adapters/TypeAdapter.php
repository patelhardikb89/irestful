<?php
namespace iRESTful\DSLs\Domain\Projects\Converters\Types\Adapters;
use iRESTful\DSLs\Domain\Projects\Primitives\Primitive;
use iRESTful\DSLs\Domain\Projects\Types\Type;

interface TypeAdapter {
    public function fromTypeToAdapterType(Type $type);
    public function fromPrimitiveToAdapterType(Primitive $primitive);
}
