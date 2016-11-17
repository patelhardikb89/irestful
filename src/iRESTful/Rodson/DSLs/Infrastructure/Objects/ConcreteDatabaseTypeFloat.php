<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Floats\FloatType;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Floats\Exceptions\FloatException;

final class ConcreteDatabaseTypeFloat implements FloatType {
    private $digitAmount;
    private $precision;
    public function __construct(int $digitAmount, int $precision) {

        if ($digitAmount <= 0) {
            throw new FloatException('The digitAmount must be greater than 0.');
        }

        if ($precision <= 0) {
            throw new FloatException('The precision must be greater than 0.');
        }

        $this->digitAmount = $digitAmount;
        $this->precision = $precision;

    }

    public function getDigitsAmount(): int {
        return $this->digitAmount;
    }

    public function getPrecision(): int {
        return $this->precision;
    }

    public function getData() {
        return [
            'digits' => $this->getDigitsAmount(),
            'precision' => $this->getPrecision()
        ];
    }


}
