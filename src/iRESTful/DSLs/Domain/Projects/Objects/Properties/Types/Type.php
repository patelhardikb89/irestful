<?php
namespace iRESTful\DSLs\Domain\Projects\Objects\Properties\Types;

interface Type {
    public function hasPrimitive();
    public function getPrimitive();
    public function hasType();
    public function getType();
    public function hasObject();
    public function getObject();
    public function isArray();
}
