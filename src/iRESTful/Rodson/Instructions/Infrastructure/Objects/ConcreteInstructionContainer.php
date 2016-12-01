<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Objects;
use iRESTful\Rodson\Instructions\Domain\Containers\Container;
use iRESTful\Rodson\Instructions\Domain\Values\Value;
use iRESTful\Rodson\ClassesEntities\Domain\Annotations\AnnotatedEntity;
use iRESTful\Rodson\Instructions\Domain\Containers\Exceptions\ContainerException;

final class ConcreteInstructionContainer implements Container {
    private $value;
    private $isLoopContainer;
    private $annotatedEntity;
    public function __construct($isLoopContainer, Value $value = null, AnnotatedEntity $annotatedEntity = null) {

        if (empty($this->loopVariableName)) {
            $this->loopVariableName = null;
        }

        $amount = (empty($value) ? 0 : 1) + (empty($annotatedEntity) ? 0 : 1) + ($isLoopContainer ? 1 : 0);
        if ($amount != 1) {
            throw new ContainerException('The instruction container must contain either a value, an annotated entity, an annotated object or a loop container.  '.$amount.' given.');
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
