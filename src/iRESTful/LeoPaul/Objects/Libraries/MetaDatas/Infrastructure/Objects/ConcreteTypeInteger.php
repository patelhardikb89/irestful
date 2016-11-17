<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Integers\IntegerType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeInteger implements IntegerType {
    private $maximumBitSize;
    public function __construct($maximumBitSize) {

        if (!is_integer($maximumBitSize)) {
            throw new TypeException('The maximumBitSize must be an integer.');
        }

        if ($maximumBitSize <= 0) {
            throw new TypeException('The maximumBitSize must be greater than 0.');
        }

        $this->maximumBitSize = $maximumBitSize;

    }

    public function getMaximumBitSize() {
        return $this->maximumBitSize;
    }

}
