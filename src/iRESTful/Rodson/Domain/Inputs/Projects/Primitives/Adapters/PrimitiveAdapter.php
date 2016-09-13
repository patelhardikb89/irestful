<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Primitives\Adapters;

interface PrimitiveAdapter {
    public function fromNameToPrimitive($name);
}
