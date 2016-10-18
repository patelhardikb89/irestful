<?php
namespace iRESTful\Classes\Infrastructure\Adapters;
use iRESTful\Classes\Domain\Interfaces\Methods\Adapters\MethodAdapter;
use iRESTful\Classes\Infrastructure\Objects\ConcreteInterfaceMethod;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\DSLs\Domain\Projects\Converters\Converter;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\Classes\Domain\Interfaces\Methods\Exceptions\MethodException;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;

final class ConcreteInterfaceMethodAdapter implements MethodAdapter {
    private $customMethodAdapter;
    private $parameterAdapter;
    public function __construct(CustomMethodAdapter $customMethodAdapter, ParameterAdapter $parameterAdapter) {
        $this->customMethodAdapter = $customMethodAdapter;
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromNameToMethod($name) {

        $matches = [];
        preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

        foreach($matches[0] as $oneElement) {
            $replacement = strtoupper(str_replace('_', '', $oneElement));
            $name = str_replace($oneElement, $replacement, $name);
        }

        return new ConcreteInterfaceMethod($name);
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
        $createMethod = function($name, Type $type, Converter $converter) use(&$parameterAdapter) {
            $parameterType = ($converter->hasFromType()) ? $converter->fromType() : $type;
            $parameter = $parameterAdapter->fromTypeToParameter($parameterType);
            return new ConcreteInterfaceMethod($name, [$parameter]);
        };

        $databaseConverter = $type->getDatabaseConverter();
        $databaseConverterMethodName = $type->getDatabaseConverterMethodName();
        $methods = [
            $createMethod($databaseConverterMethodName, $type, $databaseConverter)
        ];

        if ($type->hasViewConverter()) {
            $viewConverter = $type->getViewConverter();
            $viewConverterMethodName = $type->getViewConverterMethodName();
            $methods[] = $createMethod($viewConverterMethodName, $type, $viewConverter);
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
        $name = $property->getName();
        return $this->fromNameToMethod('get'.ucfirst($name));
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

        return new ConcreteInterfaceMethod($name, $parameters);
    }

    public function fromControllerToMethod(Controller $controller) {

        $name = $controller->getName();
        $parameter =  $this->parameterAdapter->fromDataToParameter([
            'name' => $controller->getInputName(),
            'is_array' => true
        ]);

        return new ConcreteInterfaceMethod($name, [$parameter]);
    }

}
