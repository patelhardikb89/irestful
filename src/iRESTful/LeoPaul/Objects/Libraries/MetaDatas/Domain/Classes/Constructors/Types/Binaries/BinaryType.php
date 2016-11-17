<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Binaries;

interface BinaryType {
    public function hasSpecificBitSize();
    public function getSpecificBitSize();
    public function hasMaxBitSize();
    public function getMaxBitSize();
}
