<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Integers;

interface IntegerType {
    public function getMaximumBitSize();
    public function getData();
}
