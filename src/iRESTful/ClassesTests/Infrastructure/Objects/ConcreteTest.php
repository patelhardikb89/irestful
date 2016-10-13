<?php
namespace iRESTful\ClassesTests\Infrastructure\Objects;
use iRESTful\ClassesTests\Domain\Test;
use iRESTful\ClassesTests\Domain\Transforms\Transform;
use iRESTful\ClassesTests\Domain\Exceptions\TestException;
use iRESTful\ClassesTests\Domain\Controllers\Controller;

final class ConcreteTest implements Test {
    private $transform;
    private $controller;
    public function __construct(Transform $transform = null, Controller $controller = null) {

        $amount = (empty($transform) ? 0 : 1) + (empty($controller) ? 0 : 1);
        if ($amount != 1) {
            throw new TestException('There must be either a transform or a controller test.  '.$amount.' given.');
        }

        $this->transform = $transform;
        $this->controller = $controller;
    }

    public function hasTransform() {
        return !empty($this->transform);
    }

    public function getTransform() {
        return $this->transform;
    }

    public function hasController() {
        return !empty($this->controller);
    }

    public function getController() {
        return $this->controller;
    }

}
