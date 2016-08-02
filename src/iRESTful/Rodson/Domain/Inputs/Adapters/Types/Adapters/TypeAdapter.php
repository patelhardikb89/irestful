<?php
namespace iRESTful\Rodson\Domain\Inputs\Adapters\Types\Adapters;
use iRESTful\Rodson\Domain\Inputs\Primitives\Primitive;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface TypeAdapter {
    public function fromTypeToAdapterType(Type $type);
    public function fromPrimitiveToAdapterType(Primitive $primitive);
}
