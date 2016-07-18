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

final class PHPClassMethodAdapter implements ClassMethodAdapter {
    private $parameterAdapter;
    private $interfaceMethodAdapter;
    private $propertyAdapter;
    public function __construct(ParameterAdapter $parameterAdapter, MethodAdapter $interfaceMethodAdapter, PropertyAdapter $propertyAdapter) {
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

        $getCode = function(Adapter $adapter) {
            $removeBraces = function(array $code) {
                $codeWithBraces = trim(implode(PHP_EOL, $code));
                $firstPos = strpos($codeWithBraces, '{');
                if ($firstPos === 0) {
                    $codeWithBraces = substr($codeWithBraces, 1);
                }

                $lastPos = strrpos($codeWithBraces, '}');
                $length = strlen($codeWithBraces) - 1;
                if ($lastPos === $length) {
                    $codeWithBraces = substr($codeWithBraces, 0, $length - 2);
                }

                return trim($codeWithBraces);

            };

            $codeMethod = $adapter->getMethod();
            $code = $codeMethod->getCode();
            $language = $code->getLanguage();
            if ($language->get() != 'PHP') {
                //throws
            }

            $className = $code->getClassName();
            $methodName = $codeMethod->getMethodName();

            $reflectionMethod = new \ReflectionMethod($className, $methodName);

            $fileName = $reflectionMethod->getFileName();
            $startLine = $reflectionMethod->getStartLine();
            $endLine = $reflectionMethod->getEndLine();
            $numLines = $endLine - $startLine;

            $contents = file_get_contents($fileName);
            $contentLines = explode(PHP_EOL, $contents);
            $sliced = array_slice($contentLines, $startLine, $numLines);
            return $removeBraces($sliced);
        };



        $methods = [];
        if ($type->hasDatabaseAdapter()) {
            $databaseAdapter = $type->getDatabaseAdapter();
            $code = $getCode($databaseAdapter);
            $interfaceMethod = $this->interfaceMethodAdapter->fromTypeToDatabaseAdapterMethod($type);
            $methods[] = new ConcreteClassMethod($code, $interfaceMethod);
        }

        if ($type->hasViewAdapter()) {
            $viewAdapter = $type->getViewAdapter();
            $code = $getCode($viewAdapter);
            $interfaceMethod = $this->interfaceMethodAdapter->fromTypeToViewAdapterMethod($type);
            $methods[] = new ConcreteClassMethod($code, $interfaceMethod);
        }

        return $methods;

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

    private function createClassConstructor(array $methodParameters = null) {

        $interfaceMethod = $this->interfaceMethodAdapter->fromDataToMethod([
            'name' => '__construct',
            'parameters' => $methodParameters
        ]);

        $codeLines = [];
        if (!empty($methodParameters)) {
            foreach($methodParameters as $oneMethodParameter) {
                $parameterName = $oneMethodParameter->getName();
                $codeLines[] = '$this->'.$parameterName.' = $'.$parameterName.';';
            }
        }

        $code = implode(PHP_EOL, $codeLines);
        return new ConcreteClassMethod($code, $interfaceMethod);
    }

}
