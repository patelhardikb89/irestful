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
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Methods\Adapters\MethodAdapter;

final class ConcreteClassConstructorParameterAdapter implements ConstructorParameterAdapter {
    private $namespaceAdapter;
    private $propertyAdapter;
    private $parameterAdapter;
    private $methodAdapter;
    public function __construct(
        NamespaceAdapter $namespaceAdapter,
        PropertyAdapter $propertyAdapter,
        ParameterAdapter $parameterAdapter,
        MethodAdapter $methodAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->propertyAdapter = $propertyAdapter;
        $this->parameterAdapter = $parameterAdapter;
        $this->methodAdapter = $methodAdapter;
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
        $method = $this->methodAdapter->fromPropertyToMethod($property);
        $classProperty = $this->propertyAdapter->fromNameToProperty($propertyName);

        if ($propertyType->hasPrimitive()) {
            $propertyTypePrimitive = $propertyType->getPrimitive();
            $methodParameter = $this->parameterAdapter->fromDataToParameter([
                'name' => $propertyName,
                'primitive' => $propertyTypePrimitive->getName(),
                'is_optional' => $propertyIsOptional
            ]);

            return new ConcreteClassConstructorParameter($classProperty, $methodParameter, $method);
        }

        $propertyIsArray = $propertyType->isArray();
        $namespace = $this->namespaceAdapter->fromPropertyTypeToNamespace($propertyType);
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $propertyName,
            'namespace' => $namespace,
            'is_optional' => $propertyIsOptional,
            'is_array' => $propertyIsArray
        ]);

        return new ConcreteClassConstructorParameter($classProperty, $methodParameter, $method);
    }

    public function fromTypeToParameter(Type $type) {
        $name = $type->getName();
        $classProperty = $this->propertyAdapter->fromNameToProperty($name);
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $name
        ]);

        $method = $this->methodAdapter->fromTypeToMethod($type);
        return new ConcreteClassConstructorParameter($classProperty, $methodParameter, $method);
    }

}
