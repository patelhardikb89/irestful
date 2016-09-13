<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Binaries\Binary;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Binaries\Exceptions\BinaryException;

final class ConcreteDatabaseTypeBinary implements Binary {
    private $specificBitSize;
    private $maxBitSize;
    public function __construct($specificBitSize = null, $maxBitSize = null) {

        if (!is_null($specificBitSize) && !is_null($maxBitSize)) {
            throw new BinaryException('The specificBitSize and maxBitSize cannot be both not null.');
        }

        if (!is_null($specificBitSize) && !is_int($specificBitSize)) {
            throw new BinaryException('The specificBitSize must be an integer if set.');
        }

        if (!is_null($maxBitSize) && !is_int($maxBitSize)) {
            throw new BinaryException('The maxBitSize must be an integer if set.');
        }

        if (!is_null($specificBitSize) && ($specificBitSize <= 0)) {
            throw new BinaryException('The specificBitSize must be greater than 0.');
        }

        if (!is_null($maxBitSize) && ($maxBitSize <= 0)) {
            throw new BinaryException('The maxBitSize must be greater than 0.');
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

    public function getData() {
        $output = [];
        if ($this->hasSpecificBitSize()) {
            $output['specific'] = $this->getSpecificBitSize();
        }

        if ($this->hasMaxBitSize()) {
            $output['max'] = $this->getMaxBitSize();
        }

        return $output;
    }

}
