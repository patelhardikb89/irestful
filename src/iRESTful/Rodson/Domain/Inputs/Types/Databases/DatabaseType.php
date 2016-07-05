<?php
namespace iRESTful\Rodson\Domain\Inputs\Types\Databases;

interface DatabaseType {
    public function hasBoolean();
    public function hasBinary();
    public function getBinary();
    public function hasFloat();
    public function getFloat();
    public function hasInteger();
    public function getInteger();
    public function hasString();
    public function getString();
}
