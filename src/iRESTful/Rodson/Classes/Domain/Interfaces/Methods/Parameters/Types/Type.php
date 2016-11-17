<?php
namespace iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Parameters\Types;

interface Type {
    public function isArray();
    public function hasNamespace();
    public function getNamespace();
    public function hasPrimitive();
    public function getPrimitive();
}
