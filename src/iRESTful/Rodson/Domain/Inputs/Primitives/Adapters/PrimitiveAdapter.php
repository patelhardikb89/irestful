<?php
namespace iRESTful\Rodson\Domain\Inputs\Primitives\Adapters;

interface PrimitiveAdapter {
    public function fromNameToPrimitive($name);
}
