<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Parameter as ConstructorParameter;
use iRESTful\Rodson\Domain\Middles\Classes\Properties\Property;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Parameter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Methods\Method;

final class ConcreteClassConstructorParameter implements ConstructorParameter {
    private $property;
    private $parameter;
    private $method;
    public function __construct(Property $property, Parameter $parameter, Method $method) {
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

    public function getMethod() {
        return $this->method;
    }

    public function getData() {
        return [
            'property' => $this->getProperty()->getName(),
            'parameter' => $this->getParameter()->getData(),
            'method' => $this->getMethod()->getData()
        ];
    }

}
