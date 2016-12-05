<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Adapters;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Adapters\ParameterAdapter as ConstructorParameterAdapter;
use iRESTful\Rodson\Classes\Domain\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteConstructorParameter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\InterfaceNamespaceAdapter;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Instructions\Domain\Instruction;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Exceptions\ParameterException;
use iRESTful\Rodson\Instructions\Domain\Assignments\Assignment;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;

final class ConcreteConstructorParameterAdapter implements ConstructorParameterAdapter {
    private $namespaceAdapter;
    private $propertyAdapter;
    private $parameterAdapter;
    private $methodAdapter;
    public function __construct(
        InterfaceNamespaceAdapter $namespaceAdapter,
        PropertyAdapter $propertyAdapter,
        ParameterAdapter $parameterAdapter,
        MethodAdapter $methodAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->propertyAdapter = $propertyAdapter;
        $this->parameterAdapter = $parameterAdapter;
        $this->methodAdapter = $methodAdapter;
    }

    public function fromControllerToParameters(Controller $controller) {

        $create = function(string $propertyName, string $namespaceString) {
            $namespace = $this->namespaceAdapter->fromFullDataToNamespace(explode('\\', $namespaceString));
            $property = $this->propertyAdapter->fromNameToProperty($propertyName);
            $methodParameter = $this->parameterAdapter->fromDataToParameter([
                'name' => $propertyName,
                'namespace' => $namespace
            ]);

            return new ConcreteConstructorParameter($property, $methodParameter);
        };

        return [
            $create('responseAdapter', 'iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\Adapters\ControllerResponseAdapter'),
            $create('service', 'iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Services\Service')
        ];

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

        $getNamespace = function($propertyType) {
            if ($propertyType->hasType()) {
                $type = $propertyType->getType();
                return $this->namespaceAdapter->fromTypeToNamespace($type);
            }

            if ($propertyType->hasObject()) {
                $object = $propertyType->getObject();
                return $this->namespaceAdapter->fromObjectToNamespace($object);
            }

            if ($propertyType->hasParentObject()) {
                $parentObject = $propertyType->getParentObject();
                return $this->namespaceAdapter->fromParentObjectToNamespace($parentObject);
            }

            //throws
        };

        $propertyName = $property->getName();
        $propertyIsOptional = $property->isOptional();
        $propertyType = $property->getType();
        $method = $this->methodAdapter->fromPropertyToMethod($property);
        $classProperty = $this->propertyAdapter->fromNameToProperty($propertyName);

        if ($propertyType->hasPrimitive()) {
            $propertyTypePrimitive = $propertyType->getPrimitive();
            $methodParameter = $this->parameterAdapter->fromDataToParameter([
                'name' => $propertyName,
                'primitive' => $propertyTypePrimitive,
                'is_optional' => $propertyIsOptional
            ]);

            return new ConcreteConstructorParameter($classProperty, $methodParameter, $method);
        }

        $propertyIsArray = $propertyType->isArray();
        $namespace = $getNamespace($propertyType);
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $propertyName,
            'namespace' => $namespace,
            'is_optional' => $propertyIsOptional,
            'is_array' => $propertyIsArray
        ]);

        return new ConcreteConstructorParameter($classProperty, $methodParameter, $method);
    }

    public function fromTypeToParameter(Type $type) {

        $converter = $type->getDatabaseConverter();
        $getPrimitive = function() use(&$converter) {
            if (!$converter->hasFromType()) {
                return null;
            }

            $type = $converter->fromType();
            if (!$type->hasPrimitive()) {
                return null;
            }

            return $type->getPrimitive();
        };

        $getNamespace = function() use(&$converter) {

            if (!$converter->hasFromType()) {
                return null;
            }

            $type = $converter->fromType();
            if (!$type->hasType()) {
                return null;
            }

            $typeType = $type->getType();
            return $typeType->getNamespace();

        };

        $name = $type->getName();
        $classProperty = $this->propertyAdapter->fromNameToProperty($name);
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $name,
            'primitive' => $getPrimitive(),
            'namespace' => $getNamespace()
        ]);

        $method = $this->methodAdapter->fromTypeToMethod($type);
        return new ConcreteConstructorParameter($classProperty, $methodParameter, $method);
    }

}
