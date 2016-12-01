<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types;

interface Type {
    public function isData();
    public function hasType();
    public function getType();
    public function hasPrimitive();
    public function getPrimitive();
    public function hasObjectReferenceName();
    public function getObjectReferenceName();
}
