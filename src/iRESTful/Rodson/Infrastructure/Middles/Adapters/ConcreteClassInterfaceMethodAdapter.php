<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInterfaceMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Converter;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Controller;

final class ConcreteClassInterfaceMethodAdapter implements MethodAdapter {
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
        $createMethod = function($name, Type $type, Converter $converter) use(&$parameterAdapter) {
            $parameterType = ($converter->hasFromType()) ? $converter->fromType() : $type;
            $parameter = $parameterAdapter->fromTypeToParameter($parameterType);
            return new ConcreteClassInterfaceMethod($name, [$parameter]);
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

        return new ConcreteClassInterfaceMethod($name, $parameters);
    }

    public function fromControllerToMethod(Controller $controller) {

        $name = $controller->getName();
        $parameter =  $this->parameterAdapter->fromDataToParameter([
            'name' => $controller->getInputName(),
            'is_array' => true
        ]);

        return new ConcreteClassInterfaceMethod($name, [$parameter]);
    }

}
