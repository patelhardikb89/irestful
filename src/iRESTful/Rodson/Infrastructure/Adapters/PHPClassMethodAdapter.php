<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Classes\Methods\Adapters\MethodAdapter as ClassMethodAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Outputs\Classes\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Outputs\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteClassMethod;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

final class PHPClassMethodAdapter implements ClassMethodAdapter {
    private $parameterAdapter;
    private $interfaceMethodAdapter;
    private $propertyAdapter;
    public function __construct(ParameterAdapter $parameterAdapter, MethodAdapter $interfaceMethodAdapter, PropertyAdapter $propertyAdapter) {
        $this->parameterAdapter = $parameterAdapter;
        $this->interfaceMethodAdapter = $interfaceMethodAdapter;
        $this->propertyAdapter = $propertyAdapter;
    }

    public function fromObjectToConstructor(Object $object) {

        $properties = $object->getProperties();
        $methodParameters = $this->parameterAdapter->fromPropertiesToParameters($properties);
        return $this->createClassConstructor($methodParameters);

    }

    public function fromObjectToMethods(Object $object) {

        $methods = [];
        $properties = $object->getProperties();
        foreach($properties as $oneObjectProperty) {
            $interfaceMethod = $this->interfaceMethodAdapter->fromPropertyToMethod($oneObjectProperty);
            $property = $this->propertyAdapter->fromObjectPropertyToProperty($oneObjectProperty);

            $code = 'return $this->'.$property->get().';';
            $methods[] = new ConcreteClassMethod($code, $interfaceMethod);
        }

        return $methods;

    }

    public function fromTypeToConstructor(Type $type) {

        $convert = function($name) {

            $matches = [];
            preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

            foreach($matches[0] as $oneElement) {
                $replacement = strtoupper(str_replace('_', '', $oneElement));
                $name = str_replace($oneElement, $replacement, $name);
            }

            return lcfirst($name);

        };

        $name = $type->getName();
        $methodParameter = $this->parameterAdapter->fromDataToParameter([
            'name' => $convert($name)
        ]);

        return $this->createClassConstructor([$methodParameter]);
    }

    public function fromTypeToMethods(Type $type) {

        $interfaceMethod = $this->interfaceMethodAdapter->fromDataToMethod([
            'name' => 'get'
        ]);

        $property = $this->propertyAdapter->fromTypeToProperty($type);
        $code = 'return $this->'.$property->get().';';
        $method = new ConcreteClassMethod($code, $interfaceMethod);
        return [$method];
    }

    private function createClassConstructor(array $methodParameters) {

        $interfaceMethod = $this->interfaceMethodAdapter->fromDataToMethod([
            'name' => '__construct',
            'parameters' => $methodParameters
        ]);

        $codeLines = [];
        foreach($methodParameters as $oneMethodParameter) {
            $parameterName = $oneMethodParameter->getName();
            $codeLines[] = '$this->'.$parameterName.' = $'.$parameterName.';';
        }

        $code = implode(PHP_EOL, $codeLines);
        return new ConcreteClassMethod($code, $interfaceMethod);
    }

}
