<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Converters\Types\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Primitives\Primitive;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;

interface TypeAdapter {
    public function fromTypeToAdapterType(Type $type);
    public function fromPrimitiveToAdapterType(Primitive $primitive);
}
