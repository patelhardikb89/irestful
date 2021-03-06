<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Types;

interface Type {
    public function isArray();
    public function hasPrimitive();
    public function getPrimitive();
    public function hasType();
    public function getType();
    public function hasObject();
    public function getObject();
    public function hasParentObject();
    public function getParentObject();
}
