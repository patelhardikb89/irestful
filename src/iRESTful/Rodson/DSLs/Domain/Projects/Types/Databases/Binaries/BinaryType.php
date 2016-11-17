<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Binaries;

interface BinaryType {
    public function hasSpecificBitSize();
    public function getSpecificBitSize();
    public function hasMaxBitSize();
    public function getMaxBitSize();
    public function getData();
}
