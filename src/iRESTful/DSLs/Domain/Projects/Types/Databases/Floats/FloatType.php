<?php
namespace iRESTful\DSLs\Domain\Projects\Types\Databases\Floats;

interface FloatType {
    public function getDigitsAmount();
    public function getPrecision();
    public function getData();
}
