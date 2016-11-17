<?php
namespace iRESTful\Rodson\ClassesConfigurations\Infrastructure\Objects;
use iRESTful\Rodson\ClassesConfigurations\Domain\Controllers\Controller;
use iRESTful\Rodson\ClassesControllers\Domain\Controller as ControllerClass;

final class ConcreteConfigurationController implements Controller {
    private $pattern;
    private $method;
    private $controller;
    public function __construct($pattern, $method, ControllerClass $controller) {
        $this->pattern = $pattern;
        $this->method = $method;
        $this->controller = $controller;
    }

    public function getPattern() {
        return $this->pattern;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getControllerClass() {
        return $this->controller;
    }

}
