<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Objects;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Parameter as ConstructorParameter;
use iRESTful\Rodson\Classes\Domain\Properties\Property;
use iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Parameters\Parameter;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Methods\Method;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;

final class ConcreteConstructorParameter implements ConstructorParameter {
    private $property;
    private $parameter;
    private $method;
    public function __construct(Property $property, Parameter $parameter, Method $method = null) {
        $this->property = $property;
        $this->parameter = $parameter;
        $this->method = $method;
    }

    public function getProperty() {
        return $this->property;
    }

    public function getParameter() {
        return $this->parameter;
    }

    public function hasMethod() {
        return !empty($this->method);
    }

    public function getMethod() {
        return $this->method;
    }

}
