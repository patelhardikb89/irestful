<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Getters\Adapters\GetterMethodAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Properties\Property;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassMethodGetter;

final class ConcreteClassMethodGetterAdapter implements GetterMethodAdapter {
    private $methodAdapter;
    public function __construct(MethodAdapter $methodAdapter) {
        $this->methodAdapter = $methodAdapter;
    }

    public function fromConstructorToGetterMethods(Constructor $constructor) {

        if (!$constructor->hasParameters()) {
            return [];
        }

        $methods = [];
        $parameters = $constructor->getParameters();
        foreach($parameters as $oneParameter) {
            $property = $oneParameter->getProperty();
            $methods[] = $this->fromPropertyToGetterMethod($property);
        }

        return $methods;

    }

    public function fromPropertyToGetterMethod(Property $property) {
        $propertyName = $property->get();
        $method = $this->methodAdapter->fromNameToMethod('get'.ucfirst($propertyName));

        return new ConcreteClassMethodGetter($method, $property);
    }

}
