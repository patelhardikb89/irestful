<?php
namespace iRESTful\Rodson\Domain\Types\Databases\Floats;

interface Float {
    public function getDigitsAmount();
    public function getPrecision();
}
