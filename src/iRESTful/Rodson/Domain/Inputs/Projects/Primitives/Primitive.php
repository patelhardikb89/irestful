<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Primitives;

interface Primitive {
    public function isString();
    public function isBoolean();
    public function isInteger();
    public function isFloat();
    public function getName();
}
