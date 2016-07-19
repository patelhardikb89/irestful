<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Classes\Methods\Adapters\MethodAdapter as ClassMethodAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Outputs\Classes\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Outputs\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteClassMethod;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Adapters\MethodAdapter as CodeMethodAdapter;

final class PHPClassMethodAdapter implements ClassMethodAdapter {
    private $parameterAdapter;
    private $interfaceMethodAdapter;
    private $propertyAdapter;
    public function __construct(
        ParameterAdapter $parameterAdapter,
        MethodAdapter $interfaceMethodAdapter,
        PropertyAdapter $propertyAdapter
    ) {
        $this->parameterAdapter = $parameterAdapter;
        $this->interfaceMethodAdapter = $interfaceMethodAdapter;
        $this->propertyAdapter = $propertyAdapter;
    }

    public function fromEmptyToConstructor() {
        return $this->createClassConstructor();
    }

    public function fromDataToMethods(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToMethod($oneData);
        }

        return $output;
    }

    public function fromTypeToCustomMethods(Type $type) {

        $methods = [];
        if ($type->hasDatabaseAdapter()) {
            $databaseAdapter = $type->getDatabaseAdapter();
            $codeMethod = $databaseAdapter->getMethod();
            $code = $codeMethod->getSourceCode();
            $interfaceMethod = $this->interfaceMethodAdapter->fromTypeToDatabaseAdapterMethod($type);
            $methods[] = new ConcreteClassMethod($code, $interfaceMethod);
        }

        if ($type->hasViewAdapter()) {
            $viewAdapter = $type->getViewAdapter();
            $codeMethod = $viewAdapter->getMethod();
            $code = $codeMethod->getSourceCode();
            $interfaceMethod = $this->interfaceMethodAdapter->fromTypeToViewAdapterMethod($type);
            $methods[] = new ConcreteClassMethod($code, $interfaceMethod);
        }

        return $methods;

    }

    public function fromObjectToConstructor(Object $object) {
        $methodParameters = $this->parameterAdapter->fromObjectToParameters($object);
        return $this->createClassConstructor($methodParameters, $object->hasDatabase());

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

        $constructorCodeLines = [];
        if ($type->hasMethod()) {
            $method = $type->getMethod();
            $methodCode = $method->getSourceCode();
            $constructorCodeLines = explode(PHP_EOL, $methodCode);
        }

        return $this->createClassConstructor([$methodParameter], false, $constructorCodeLines);
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

    private function createClassConstructor(array $methodParameters = null, $isEntity = false, array $additionalCodeLines = null) {

        $interfaceMethod = $this->interfaceMethodAdapter->fromDataToMethod([
            'name' => '__construct',
            'parameters' => $methodParameters
        ]);


        $parentParams = [];
        $assignments = [];
        if (!empty($methodParameters)) {
            foreach($methodParameters as $oneMethodParameter) {
                $parameterName = $oneMethodParameter->getName();
                if ($oneMethodParameter->isParent()) {
                    $parentParams[] = '$'.$parameterName;
                    continue;
                }

                $assignments[] = '$this->'.$parameterName.' = $'.$parameterName.';';
            }
        }

        $codeLines = [];
        if (!empty($additionalCodeLines)) {
            $codeLines = $additionalCodeLines;
        }

        if ($isEntity) {
            $codeLines[] = 'parent::__construct('.implode(', ', $parentParams).');';
        }

        $code = implode(PHP_EOL, array_merge($codeLines, $assignments));
        return new ConcreteClassMethod($code, $interfaceMethod);
    }

}
