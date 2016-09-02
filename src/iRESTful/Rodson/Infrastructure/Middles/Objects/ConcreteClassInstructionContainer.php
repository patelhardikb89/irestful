<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Container;
use iRESTful\Rodson\Domain\Inputs\Values\Value;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Exceptions\ContainerException;

final class ConcreteClassInstructionContainer implements Container {
    private $value;
    private $annotatedClass;
    public function __construct(Value $value = null, AnnotatedClass $annotatedClass = null) {

        $amount = (empty($value) ? 0 : 1) + (empty($annotatedClass) ? 0 : 1);
        if ($amount != 1) {
            throw new ContainerException('The instruction container must contain either a value or an annotated class.  '.$amount.' given.');
        }

        $this->value = $value;
        $this->annotatedClass = $annotatedClass;

    }

    public function hasValue() {
        return !empty($this->value);
    }

    public function getValue() {
        return $this->value;
    }

    public function hasAnnotatedClass() {
        return !empty($this->annotatedClass);
    }

    public function getAnnotatedClass() {
        return $this->annotatedClass;
    }

}
