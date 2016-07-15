<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Classes\Methods\Adapters\MethodAdapter as ClassMethodAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Outputs\Classes\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Outputs\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteClassMethod;

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

}
