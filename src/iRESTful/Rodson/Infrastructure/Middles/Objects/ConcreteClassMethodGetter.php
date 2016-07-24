<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Getters\GetterMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Method;
use iRESTful\Rodson\Domain\Middles\Classes\Properties\Property;

final class ConcreteClassMethodGetter implements GetterMethod {
    private $interfaceMethod;
    private $property;
    public function __construct(Method $interfaceMethod, Property $property) {
        $this->interfaceMethod = $interfaceMethod;
        $this->property = $property;
    }

    public function getInterfaceMethod() {
        return $this->interfaceMethod;
    }

    public function getReturnedProperty() {
        return $this->property;
    }

}
