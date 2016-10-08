<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Container;
use iRESTful\Rodson\Domain\Inputs\Projects\Values\Value;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\AnnotatedEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Exceptions\ContainerException;

final class ConcreteClassInstructionContainer implements Container {
    private $value;
    private $isLoopContainer;
    private $annotatedEntity;
    public function __construct($isLoopContainer, Value $value = null, AnnotatedEntity $annotatedEntity = null) {

        if (empty($this->loopVariableName)) {
            $this->loopVariableName = null;
        }

        $amount = (empty($value) ? 0 : 1) + (empty($annotatedEntity) ? 0 : 1) + ($isLoopContainer ? 1 : 0);
        if ($amount != 1) {
            throw new ContainerException('The instruction container must contain either a value, an annotated entity or a loop container.  '.$amount.' given.');
        }

        $this->value = $value;
        $this->isLoopContainer = $isLoopContainer;
        $this->annotatedEntity = $annotatedEntity;

    }

    public function isLoopContainer() {
        return $this->isLoopContainer;
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
