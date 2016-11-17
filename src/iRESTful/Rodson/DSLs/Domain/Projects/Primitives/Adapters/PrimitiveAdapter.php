<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Primitives\Adapters;

interface PrimitiveAdapter {
    public function fromNameToPrimitive($name);
}
