<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Binaries;

interface Binary {
    public function hasSpecificBitSize();
    public function getSpecificBitSize();
    public function hasMaxBitSize();
    public function getMaxBitSize();
    public function getData();
}
