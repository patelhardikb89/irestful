<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Integers\Integer;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Integers\Exceptions\IntegerException;

final class ConcreteDatabaseTypeInteger implements Integer {
    private $maximumBitSize;
    public function __construct($maximumBitSize) {

        if (!is_integer($maximumBitSize)) {
            throw new IntegerException('The maximumBitSize must be an integer.');
        }

        if ($maximumBitSize <= 0) {
            throw new IntegerException('The maximumBitSize must be greater than 0.');
        }

        $this->maximumBitSize = $maximumBitSize;

    }

    public function getMaximumBitSize() {
        return $this->maximumBitSize;
    }

}
