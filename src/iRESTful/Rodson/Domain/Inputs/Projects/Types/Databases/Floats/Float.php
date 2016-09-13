<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Floats;

interface Float {
    public function getDigitsAmount();
    public function getPrecision();
    public function getData();
}
