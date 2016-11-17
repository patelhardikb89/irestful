<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types;

interface Type {
    public function hasBinary();
    public function getBinary();
    public function hasFloat();
    public function getFloat();
    public function hasInteger();
    public function getInteger();
    public function hasString();
    public function getString();
    public function isBoolean();
}
