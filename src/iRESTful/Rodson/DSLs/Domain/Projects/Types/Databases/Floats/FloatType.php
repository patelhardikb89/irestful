<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Floats;

interface FloatType {
    public function getDigitsAmount();
    public function getPrecision();
    public function getData();
}
