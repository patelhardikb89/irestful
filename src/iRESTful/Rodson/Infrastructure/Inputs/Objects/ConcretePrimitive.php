<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Primitives\Primitive;
use iRESTful\Rodson\Domain\Inputs\Primitives\Exceptions\PrimitiveException;

final class ConcretePrimitive implements Primitive {
    private $isString;
    private $isBoolean;
    private $isInteger;
    private $isFloat;
    public function __construct($isString, $isBoolean, $isInteger, $isFloat) {

        $amount = ($isString ? 1 : 0) + ($isBoolean ? 1 : 0) + ($isInteger ? 1 : 0) + ($isFloat ? 1 : 0);
        if ($amount != 1) {
            throw new PrimitiveException('The primitive can either be a string, boolean, integer or a float.  '.$amount.' provided.');
        }

        $this->isString = (bool) $isString;
        $this->isBoolean = (bool) $isBoolean;
        $this->isInteger = (bool) $isInteger;
        $this->isFloat = (bool) $isFloat;
    }

    public function isString() {
        return $this->isString;
    }

    public function isBoolean() {
        return $this->isBoolean;
    }

    public function isInteger() {
        return $this->isInteger;
    }

    public function isFloat() {
        return $this->isFloat;
    }

    public function getName() {

        if ($this->isString()) {
            return 'string';
        }

        if ($this->isBoolean()) {
            return 'boolean';
        }

        if ($this->isInteger()) {
            return 'integer';
        }

        if ($this->isFloat()) {
            return 'float';
        }

        return '';

    }

}
