<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Floats\FloatType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeFloat implements FloatType {
    private $digitAmount;
    private $precision;
    public function __construct($digitAmount, $precision) {

        if (!is_integer($digitAmount)) {
            throw new TypeException('The digitAmount must be an integer.');
        }

        if (!is_integer($precision)) {
            throw new TypeException('The precision must be an integer.');
        }

        if ($digitAmount <= 0) {
            throw new TypeException('The digitAmount must be greater than 0.');
        }

        if ($precision <= 0) {
            throw new TypeException('The precision must be greater than 0.');
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

}
