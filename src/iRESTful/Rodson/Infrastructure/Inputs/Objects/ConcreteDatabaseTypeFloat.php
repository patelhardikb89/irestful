<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Floats\Float;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Floats\Exceptions\FloatException;

final class ConcreteDatabaseTypeFloat implements Float {
    private $digitAmount;
    private $precision;
    public function __construct($digitAmount, $precision) {

        if (!is_integer($digitAmount)) {
            throw new FloatException('The digitAmount must be an integer.');
        }

        if (!is_integer($precision)) {
            throw new FloatException('The precision must be an integer.');
        }

        if ($digitAmount <= 0) {
            throw new FloatException('The digitAmount must be greater than 0.');
        }

        if ($precision <= 0) {
            throw new FloatException('The precision must be greater than 0.');
        }

        $this->digitAmount = $digitAmount;
        $this->precision = $precision;

    }

    public function getDigitsAmount() {
        return $this->digitAmount;
    }

    public function getPrecision() {
        return $this->precision;
    }

    public function getData() {
        return [
            'digits' => $this->getDigitsAmount(),
            'precision' => $this->getPrecision()
        ];
    }

}
