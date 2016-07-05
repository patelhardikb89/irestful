<?php
namespace iRESTful\Rodson\Domain\Inputs\Types\Databases\Floats;

interface Float {
    public function getDigitsAmount();
    public function getPrecision();
}
