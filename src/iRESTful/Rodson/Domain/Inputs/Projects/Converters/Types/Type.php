<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Converters\Types;

interface Type {
    public function hasType();
    public function getType();
    public function hasPrimitive();
    public function getPrimitive();
}
