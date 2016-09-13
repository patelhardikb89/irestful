<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Types;

interface Type {
    public function hasPrimitive();
    public function getPrimitive();
    public function hasType();
    public function getType();
    public function hasObject();
    public function getObject();
    public function isArray();
}
