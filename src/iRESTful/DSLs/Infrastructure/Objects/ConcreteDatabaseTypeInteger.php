<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Integers\IntegerType;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Integers\Exceptions\IntegerException;

final class ConcreteDatabaseTypeInteger implements IntegerType {
    private $maximumBitSize;
    public function __construct(int $maximumBitSize) {

        if ($maximumBitSize <= 0) {
            throw new IntegerException('The maximumBitSize must be greater than 0.');
        }

        $this->maximumBitSize = $maximumBitSize;

    }

    public function getMaximumBitSize(): int {
        return $this->maximumBitSize;
    }

    public function getData() {
        return [
            'max' => $this->getMaximumBitSize()
        ];
    }

}
