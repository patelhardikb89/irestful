<?php
namespace iRESTful\DSLs\Domain\Projects\Primitives\Adapters;

interface PrimitiveAdapter {
    public function fromNameToPrimitive($name);
}
