<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Binaries\BinaryType;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Binaries\Exceptions\BinaryException;

final class ConcreteDatabaseTypeBinary implements BinaryType {
    private $specificBitSize;
    private $maxBitSize;
    public function __construct(int $specificBitSize = null, int $maxBitSize = null) {

        if (!is_null($specificBitSize) && !is_null($maxBitSize)) {
            throw new BinaryException('The specificBitSize and maxBitSize cannot be both not null.');
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

    public function hasSpecificBitSize(): bool {
        return !empty($this->specificBitSize);
    }

    public function getSpecificBitSize() {
        return $this->specificBitSize;
    }

    public function hasMaxBitSize(): bool {
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
