<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Primitives\Primitive;
use iRESTful\DSLs\Domain\Projects\Primitives\Exceptions\PrimitiveException;

final class ConcretePrimitive implements Primitive {
    private $isString;
    private $isBoolean;
    private $isInteger;
    private $isFloat;
    public function __construct(bool $isString, bool $isBoolean, bool $isInteger, bool $isFloat) {

        $amount = ($isString ? 1 : 0) + ($isBoolean ? 1 : 0) + ($isInteger ? 1 : 0) + ($isFloat ? 1 : 0);
        if ($amount != 1) {
            throw new PrimitiveException('The primitive can either be a string, boolean, integer or a float.  '.$amount.' provided.');
        }

        $this->isString = $isString;
        $this->isBoolean = $isBoolean;
        $this->isInteger = $isInteger;
        $this->isFloat = $isFloat;
    }

    public function isString(): bool {
        return $this->isString;
    }

    public function isBoolean(): bool {
        return $this->isBoolean;
    }

    public function isInteger(): bool {
        return $this->isInteger;
    }

    public function isFloat(): bool {
        return $this->isFloat;
    }

    public function getName(): string {

        if ($this->isString) {
            return 'string';
        }

        if ($this->isBoolean) {
            return 'bool';
        }

        if ($this->isInteger) {
            return 'int';
        }

        return 'float';

    }

}
