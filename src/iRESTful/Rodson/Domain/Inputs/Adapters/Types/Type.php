<?php
namespace iRESTful\Rodson\Domain\Inputs\Adapters\Types;

interface Type {
    public function hasType();
    public function getType();
    public function hasPrimitive();
    public function getPrimitive();
}
