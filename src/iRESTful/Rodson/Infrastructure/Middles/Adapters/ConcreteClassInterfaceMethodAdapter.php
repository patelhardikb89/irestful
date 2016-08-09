<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInterfaceMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;

final class ConcreteClassInterfaceMethodAdapter implements MethodAdapter {
    private $customMethodAdapter;
    private $parameterAdapter;
    public function __construct(CustomMethodAdapter $customMethodAdapter, ParameterAdapter $parameterAdapter) {
        $this->customMethodAdapter = $customMethodAdapter;
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromNameToMethod($name) {
        return new ConcreteClassInterfaceMethod($name);
    }

    public function fromObjectToMethods(Object $object) {

        $properties = $object->getProperties();
        $getterMethods = $this->fromPropertiesToMethods($properties);

        $specificMethods = [];
        if ($object->hasMethods()) {
            $customMethods = $this->customMethodAdapter->fromObjectToCustomMethods($object);
            $specificMethods = $this->fromCustomMethodsToMethods($customMethods);
        }

        return array_merge($getterMethods, $specificMethods);
    }

    public function fromTypeToMethod(Type $type) {
        return $this->fromNameToMethod('get');
    }

    public function fromTypeToAdapterMethods(Type $type) {

        $parameterAdapter = $this->parameterAdapter;
        $createMethod = function($name, Type $type, Adapter $adapter) use(&$parameterAdapter) {
            $parameterType = ($adapter->hasFromType()) ? $adapter->fromType() : $type;
            $parameter = $parameterAdapter->fromTypeToParameter($parameterType);
            return new ConcreteClassInterfaceMethod($name, [$parameter]);
        };

        $databaseAdapter = $type->getDatabaseAdapter();
        $databaseAdapterMethodName = $type->getDatabaseAdapterMethodName();
        $methods = [
            $createMethod($databaseAdapterMethodName, $type, $databaseAdapter)
        ];

        if ($type->hasViewAdapter()) {
            $viewAdapter = $type->getViewAdapter();
            $viewAdapterMethodName = $type->getViewAdapterMethodName();
            $methods[] = $createMethod($viewAdapterMethodName, $type, $viewAdapter);
        }

        return $methods;

    }

    private function fromPropertiesToMethods(array $properties) {
        $methods = [];
        foreach($properties as $oneProperty) {
            $methods[] = $this->fromPropertyToMethod($oneProperty);
        }

        return $methods;
    }

    private function fromPropertyToMethod(Property $property) {
        $type = $property->getType();
        if ($type->hasObject()) {
            $object = $type->getObject();
            $objectName = $object->getName();
            return $this->fromNameToMethod('get'.ucfirst($objectName));
        }

        if ($type->hasType()) {
            $typeType = $type->getType();
            $typeTypeName = $typeType->getName();
            return $this->fromNameToMethod('get'.ucfirst($typeTypeName));
        }

        if ($type->hasPrimitive()) {
            $primitive = $type->getPrimitive();
            $primitiveName = $primitive->getName();
            return $this->fromNameToMethod('get'.ucfirst($primitiveName));
        }

        throw new MethodException('The given PropertyType object did not have a Primitive, an Object or a Type.');

    }

    private function fromCustomMethodsToMethods(array $customMethods) {
        $output = [];
        foreach($customMethods as $oneCustomMethod) {
            $output[] = $this->fromCustomMethodToMethod($oneCustomMethod);
        }

        return $output;
    }

    private function fromCustomMethodToMethod(CustomMethod $customMethod) {
        $name = $customMethod->getName();

        $parameters = null;
        if ($customMethod->hasParameters()) {
            $parameters = $customMethod->getParameters();
        }

        return new ConcreteClassInterfaceMethod($name, $parameters);
    }

}
