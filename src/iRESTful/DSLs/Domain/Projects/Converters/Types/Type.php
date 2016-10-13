<?php
namespace iRESTful\DSLs\Domain\Projects\Converters\Types;

interface Type {
    public function hasType();
    public function getType();
    public function hasPrimitive();
    public function getPrimitive();
}
