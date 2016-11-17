<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Binaries\BinaryType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Floats\FloatType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Integers\IntegerType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Strings\StringType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteType implements Type {
    private $binary;
    private $float;
    private $integer;
    private $string;
    private $isBoolean;
    public function __construct(BinaryType $binary = null, FloatType $float = null, IntegerType $integer = null, StringType $string = null, $isBoolean = false) {

        $amount = (empty($binary) ? 0 : 1) + (empty($float) ? 0 : 1) + (empty($integer) ? 0 : 1) + (empty($string) ? 0 : 1) + ($isBoolean ? 1 : 0);
        if ($amount != 1) {
            throw new TypeException('There must be either a binary, float, integer, string or boolean.  '.$amount.' given.');
        }

        $this->binary = $binary;
        $this->float = $float;
        $this->integer = $integer;
        $this->string = $string;
        $this->isBoolean = $isBoolean;
    }

    public function hasBinary() {
        return !empty($this->binary);
    }

    public function getBinary() {
        return $this->binary;
    }

    public function hasFloat() {
        return !empty($this->float);
    }

    public function getFloat() {
        return $this->float;
    }

    public function hasInteger() {
        return !empty($this->integer);
    }

    public function getInteger() {
        return $this->integer;
    }

    public function hasString() {
        return !empty($this->string);
    }

    public function getString() {
        return $this->string;
    }

    public function isBoolean() {
        return $this->isBoolean;
    }

}
