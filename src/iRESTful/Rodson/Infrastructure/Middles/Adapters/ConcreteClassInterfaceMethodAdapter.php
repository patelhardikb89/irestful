<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInterfaceMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Getters\GetterMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;

final class ConcreteClassInterfaceMethodAdapter implements MethodAdapter {
    private $parameterAdapter;
    public function __construct(ParameterAdapter $parameterAdapter) {
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromNameToMethod($name) {
        return new ConcreteClassInterfaceMethod($name);
    }

    public function fromObjectToMethods(Object $object) {

        $properties = $object->getProperties();
        $getterMethods = $this->fromPropertiesToMethods($properties);

        $specificMethods = [];
        /*if ($object->hasMethods()) {
            $objectMethods = $object->getMethods();
            $specificMethods = $this->fromCustomMethodsToMethods($customMethods);
        }*/

        return array_merge($getterMethods, $specificMethods);
    }

    public function fromTypeToMethod(Type $type) {
        return $this->fromNameToMethod('get');
    }

    public function fromTypeToAdapterMethods(Type $type) {

        $currentTypeName = $type->getName();
        $getName = function(Adapter $adapter) use(&$currentTypeName) {

            $fromName = $currentTypeName;
            if ($adapter->hasFromType()) {
                $fromName = $adapter->fromType()->getName();
            }

            $toName = $currentTypeName;
            if ($adapter->hasToType()) {
                $toName = $adapter->toType()->getName();
            }

            return 'from'.ucfirst($fromName).'To'.ucfirst($toName);

        };

        $parameterAdapter = $this->parameterAdapter;
        $createMethod = function(Type $type, Adapter $adapter) use(&$getName, &$parameterAdapter) {
            $name = $getName($adapter);
            $parameterType = ($adapter->hasFromType()) ? $adapter->fromType() : $type;
            $parameter = $parameterAdapter->fromTypeToParameter($parameterType);
            return new ConcreteClassInterfaceMethod($name, [$parameter]);
        };

        $methods = [];
        if ($type->hasDatabaseAdapter()) {
            $databaseAdapter = $type->getDatabaseAdapter();
            $methods[] = $createMethod($type, $databaseAdapter);
        }

        if ($type->hasViewAdapter()) {
            $viewAdapter = $type->getViewAdapter();
            $methods[] = $createMethod($type, $viewAdapter);
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

        throw new MethodException('The given PropertyType object did not have an Object or a Type.');

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
