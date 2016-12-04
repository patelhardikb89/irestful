<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Adapters;
use iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteInterfaceMethod;
use iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Converter;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Exceptions\MethodException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;

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
        return $this->fromPropertiesToMethods($properties);
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
        $databaseConverterFunctionName = $type->getDatabaseConverterFunctionName();
        $methods = [
            $createMethod($databaseConverterFunctionName, $type, $databaseConverter)
        ];

        if ($type->hasViewConverter()) {
            $viewConverter = $type->getViewConverter();
            $viewConverterFunctionName = $type->getViewConverterFunctionName();
            $methods[] = $createMethod($viewConverterFunctionName, $type, $viewConverter);
        }

        return $methods;

    }

    public function fromObjectToAdapterMethods(Object $object) {

        if ($object->hasConverters()) {
            //throws
        }

        $output = [];
        $converters = $object->getConverters();
        foreach($converters as $oneConverter) {

            if (!$oneConverter->hasMethod()) {
                continue;
            }

            $method = $oneConverter->getMethod();
            $customMethod = $this->customMethodAdapter->fromMethodToCustomMethod($method);
            $output[] = $this->fromCustomMethodToMethod($customMethod);
        }

        return $output;

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
