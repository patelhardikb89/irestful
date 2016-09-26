<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\SpecificClass;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\AnnotatedEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Values\Value;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Classes\Exceptions\ClassException;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Test;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Annotations\AnnotatedObject;
use iRESTful\Rodson\Domain\Middles\Applications\Application;
use iRESTful\Rodson\Domain\Middles\Installations\Installation;

final class ConcreteSpecificClass implements SpecificClass {
    private $annotatedObject;
    private $annotatedEntity;
    private $value;
    private $controller;
    private $test;
    private $application;
    private $installation;
    public function __construct(
        AnnotatedObject $annotatedObject = null,
        AnnotatedEntity $annotatedEntity = null,
        Value $value = null,
        Controller $controller = null,
        Test $test = null,
        Application $application = null,
        Installation $installation = null
    ) {

        $amount = (empty($annotatedObject) ? 0 : 1) +  (empty($annotatedEntity) ? 0 : 1) + (empty($value) ? 0 : 1) + (empty($controller) ? 0 : 1) + (empty($test) ? 0 : 1) + (empty($application) ? 0 : 1) + (empty($installation) ? 0 : 1);
        if ($amount != 1) {
            throw new ClassException('The class must either have an AnnotatedObject, AnnotatedEntity, Value, Controller, Test or Application.  '.$amount.' given.');
        }

        $this->annotatedObject = $annotatedObject;
        $this->annotatedEntity = $annotatedEntity;
        $this->value = $value;
        $this->controller = $controller;
        $this->test = $test;
        $this->application = $application;
        $this->installation = $installation;
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

    public function hasApplication() {
        return !empty($this->application);
    }

    public function getApplication() {
        return $this->application;
    }

    public function hasInstallation() {
        return !empty($this->installation);
    }

    public function getInstallation() {
        return $this->installation;
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

        if ($this->hasApplication()) {
            return $this->application->getNamespace();
        }

        if ($this->hasInstallation()) {
            return $this->application->getInstallation();
        }

        return $this->test->getNamespace();

    }

}
