<?php
namespace iRESTful\Rodson\Domain\Inputs\Types\Databases\Integers;

interface Integer {
    public function getMaximumBitSize();
    public function getData();
}
