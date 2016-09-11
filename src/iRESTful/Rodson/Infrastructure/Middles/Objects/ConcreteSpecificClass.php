<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\SpecificClass;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\AnnotatedEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Values\Value;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Classes\Exceptions\ClassException;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Test;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Annotations\AnnotatedObject;

final class ConcreteSpecificClass implements SpecificClass {
    private $annotatedObject;
    private $annotatedEntity;
    private $value;
    private $controller;
    private $test;
    public function __construct(AnnotatedObject $annotatedObject = null, AnnotatedEntity $annotatedEntity = null, Value $value = null, Controller $controller = null, Test $test = null) {

        $amount = (empty($annotatedObject) ? 0 : 1) +  (empty($annotatedEntity) ? 0 : 1) + (empty($value) ? 0 : 1) + (empty($controller) ? 0 : 1) + (empty($test) ? 0 : 1);
        if ($amount != 1) {
            throw new ClassException('The class must either have an AnnotatedObject, AnnotatedEntity, Value, Controller or Test.  '.$amount.' given.');
        }

        $this->annotatedObject = $annotatedObject;
        $this->annotatedEntity = $annotatedEntity;
        $this->value = $value;
        $this->controller = $controller;
        $this->test = $test;
    }

    public function hasAnnotatedObject() {
        return !empty($this->annotatedObject);
    }

    public function getAnnotatedObject() {
        return $this->annotatedObject;
    }

    public function hasAnnotatedEntity() {
        return !empty($this->annotatedEntity);
    }

    public function getAnnotatedEntity() {
        return $this->annotatedEntity;
    }

    public function hasValue() {
        return !empty($this->value);
    }

    public function getValue() {
        return $this->value;
    }

    public function hasController() {
        return !empty($this->controller);
    }

    public function getController() {
        return $this->controller;
    }

    public function hasTest() {
        return !empty($this->test);
    }

    public function getTest() {
        return $this->test;
    }

    public function getNamespace() {

        if ($this->hasObject()) {
            return $this->object->getNamespace();
        }

        if ($this->hasEntity()) {
            return $this->entity->getNamespace();
        }

        if ($this->hasValue()) {
            return $this->value->getNamespace();
        }

        if ($this->hasController()) {
            return $this->controller->getNamespace();
        }

        return $this->test->getNamespace();

    }

}
