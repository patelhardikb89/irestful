<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Adapters\ParameterAdapter as ConstructorParameterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassConstructorParameter;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\Adapters\NamespaceAdapter;

final class ConcreteClassConstructorParameterAdapter implements ConstructorParameterAdapter {
    private $namespaceAdapter;
    private $propertyAdapter;
    private $parameterAdapter;
    public function __construct(NamespaceAdapter $namespaceAdapter, PropertyAdapter $propertyAdapter, ParameterAdapter $parameterAdapter) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->propertyAdapter = $propertyAdapter;
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromObjectToParameters(Object $object) {
        $output = [];
        $properties = $object->getProperties();
        foreach($properties as $oneProperty) {
            $output[] = $this->fromPropertyToParameter($oneProperty);
        }

        return $output;
    }

    public function fromPropertyToParameter(Property $property) {

        $propertyName = $property->getName();
        $propertyIsOptional = $property->isOptional();
        $propertyType = $property->getType();
        $propertyIsArray = $propertyType->isArray();

        $namespace = $this->namespaceAdapter->fromPropertyTypeToNamespace($propertyType);
        $classProperty = $this->propertyAdapter->fromNameToProperty($propertyName);
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $propertyName,
            'namespace' => $namespace,
            'is_optional' => $propertyIsOptional,
            'is_array' => $propertyIsArray
        ]);

        return new ConcreteClassConstructorParameter($classProperty, $methodParameter);
    }

    public function fromTypeToParameter(Type $type) {
        $name = $type->getName();
        $classProperty = $this->propertyAdapter->fromNameToProperty($name);
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $name
        ]);

        return new ConcreteClassConstructorParameter($classProperty, $methodParameter);
    }

}
