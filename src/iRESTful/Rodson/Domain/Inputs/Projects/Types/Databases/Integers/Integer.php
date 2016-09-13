<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Integers;

interface Integer {
    public function getMaximumBitSize();
    public function getData();
}
