<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Configurations\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Controller as ControllerClass;

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

    public function getData() {
        return [
            'pattern' => $this->pattern,
            'method' => $this->method,
            'class' => $this->controller->getData()
        ];
    }

}
