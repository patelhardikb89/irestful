<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Container;
use iRESTful\Rodson\Domain\Inputs\Values\Value;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\AnnotatedEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Exceptions\ContainerException;

final class ConcreteClassInstructionContainer implements Container {
    private $value;
    private $annotatedEntity;
    public function __construct(Value $value = null, AnnotatedEntity $annotatedEntity = null) {

        $amount = (empty($value) ? 0 : 1) + (empty($annotatedEntity) ? 0 : 1);
        if ($amount != 1) {
            throw new ContainerException('The instruction container must contain either a value or an annotated entity.  '.$amount.' given.');
        }

        $this->value = $value;
        $this->annotatedEntity = $annotatedEntity;

    }

    public function hasValue() {
        return !empty($this->value);
    }

    public function getValue() {
        return $this->value;
    }

    public function hasAnnotatedEntity() {
        return !empty($this->annotatedEntity);
    }

    public function getAnnotatedEntity() {
        return $this->annotatedEntity;
    }

}
