<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Test;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms\Transform;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Exceptions\TestException;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Controllers\Controller;

final class ConcreteSpecificClassTest implements Test {
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
