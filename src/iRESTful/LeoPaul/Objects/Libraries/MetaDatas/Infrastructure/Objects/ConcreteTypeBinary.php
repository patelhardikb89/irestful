<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Binaries\BinaryType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeBinary implements BinaryType {
    private $specificBitSize;
    private $maxBitSize;
    public function __construct($specificBitSize = null, $maxBitSize = null) {

        if (!is_null($specificBitSize) && !is_null($maxBitSize)) {
            throw new TypeException('The specificBitSize and maxBitSize cannot be both not null.');
        }

        if (!is_null($specificBitSize) && !is_int($specificBitSize)) {
            throw new TypeException('The specificBitSize must be an integer if set.');
        }

        if (!is_null($maxBitSize) && !is_int($maxBitSize)) {
            throw new TypeException('The maxBitSize must be an integer if set.');
        }

        if (!is_null($specificBitSize) && ($specificBitSize <= 0)) {
            throw new TypeException('The specificBitSize must be greater than 0.');
        }

        if (!is_null($maxBitSize) && ($maxBitSize <= 0)) {
            throw new TypeException('The maxBitSize must be greater than 0.');
        }

        $this->specificBitSize = $specificBitSize;
        $this->maxBitSize = $maxBitSize;
    }

    public function hasSpecificBitSize() {
        return !empty($this->specificBitSize);
    }

    public function getSpecificBitSize() {
        return $this->specificBitSize;
    }

    public function hasMaxBitSize() {
        return !empty($this->maxBitSize);
    }

    public function getMaxBitSize() {
        return $this->maxBitSize;
    }

}
