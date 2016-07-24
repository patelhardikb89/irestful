<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Parameter as ConstructorParameter;
use iRESTful\Rodson\Domain\Middles\Classes\Properties\Property;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Parameter;

final class ConcreteClassConstructorParameter implements ConstructorParameter {
    private $property;
    private $parameter;
    public function __construct(Property $property, Parameter $parameter) {
        $this->property = $property;
        $this->parameter = $parameter;
    }

    public function getProperty() {
        return $this->property;
    }

    public function getParameter() {
        return $this->parameter;
    }

}
