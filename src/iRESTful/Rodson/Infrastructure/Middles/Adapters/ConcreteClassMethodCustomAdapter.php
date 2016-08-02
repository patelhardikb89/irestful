<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Methods\Method;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Exceptions\CustomMethodException;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassMethodCustom;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Method as CodeMethod;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapter;

final class ConcreteClassMethodCustomAdapter implements CustomMethodAdapter {
    private $parameterAdapter;
    public function __construct(ParameterAdapter $parameterAdapter) {
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromObjectToCustomMethods(Object $object) {

        if (!$object->hasMethods()) {
            return [];
        }

        $methods = $object->getMethods();
        return $this->fromMethodsToCustomMethods($methods);

    }

    public function fromTypeToCustomMethod(Type $type) {
        if ($type->hasMethod()) {
            return null;
        }

        $method = $type->getMethod();
        return $this->fromMethodToCustomMethod($method);
    }

    public function fromTypeToAdapterCustomMethods(Type $type) {

        $customMethods = [];
        if ($type->hasDatabaseAdapter()) {
            $databaseAdapterMethod = $type->getDatabaseAdapter()->getMethod();
            $databaseAdapterName = $type->getDatabaseAdapterMethodName();
            $customMethods[] = $this->createClassMethodCustom($databaseAdapterName, $databaseAdapterMethod);
        }

        if ($type->hasViewAdapter()) {
            $viewAdapterMethod = $type->getViewAdapter()->getMethod();
            $viewAdapterName = $type->getViewAdapterMethodName();
            $customMethods[] = $this->createClassMethodCustom($viewAdapterName, $viewAdapterMethod);
        }

        return $customMethods;

    }

    public function fromMethodsToCustomMethods(array $methods) {
        $output = [];
        foreach($methods as $oneMethod) {
            $output[] = $this->fromMethodToCustomMethod($oneMethod);
        }

        return $output;
    }

    public function fromMethodToCustomMethod(Method $method) {
        $name = $method->getName();
        $codeMethod = $method->getMethod();
        return $this->createClassMethodCustom($name, $codeMethod);
    }

    private function createClassMethodCustom($name, CodeMethod $codeMethod) {

        $removeBraces = function(array $code) {

            $fixIndentation = function(array $lines) {
                $output = [];
                $rightSize = 0;
                $size = null;
                $amountToAdd = null;
                $amountToSubstract = null;
                foreach($lines as $index => $oneLine) {

                    if (is_null($size)) {
                        $size = strlen($oneLine) - strlen(ltrim($oneLine));

                        if ($size < $rightSize) {
                            $amountToAdd = $rightSize - $size;
                        }

                        if ($size > $rightSize) {
                            $amountToSubstract = $size - $rightSize;
                        }
                    }

                    $filtered = '';
                    if (!is_null($amountToAdd)) {
                        $filtered = str_repeat(' ', $amountToAdd).$oneLine;
                    }

                    if (!is_null($amountToSubstract)) {
                        $filtered = substr($oneLine, $amountToSubstract);
                    }

                    if (!empty($filtered)) {
                        $output[$index] = $filtered;
                    }

                }

                return $output;
            };

            $codeWithBraces = implode(PHP_EOL, $code);
            $firstPos = strpos($codeWithBraces, '{');
            if ($firstPos === 0) {
                $codeWithBraces = substr($codeWithBraces, 1);
            }

            $lastPos = strrpos($codeWithBraces, '}');
            $length = strlen($codeWithBraces) - 1;
            if ($lastPos === $length) {
                $codeWithBraces = substr($codeWithBraces, 0, $length - 2);
            }

            $lines = explode(PHP_EOL, $codeWithBraces);
            return $fixIndentation(array_values(array_filter($lines)));

        };

        $getSourceCodeLines = function(\ReflectionMethod $reflectionMethod) use(&$removeBraces) {

            $fileName = $reflectionMethod->getFileName();
            $startLine = $reflectionMethod->getStartLine();
            $endLine = $reflectionMethod->getEndLine();
            $numLines = $endLine - $startLine;

            $contents = file_get_contents($fileName);
            $contentLines = explode(PHP_EOL, $contents);
            $sliced = array_slice($contentLines, $startLine, $numLines);
            return $removeBraces($sliced);
        };

        $parameterAdapter = $this->parameterAdapter;
        $getParameters = function(\ReflectionMethod $reflectionMethod) use(&$parameterAdapter) {
            $parameters = [];
            $reflectionParameters = $reflectionMethod->getParameters();
            foreach($reflectionParameters as $oneReflectionParameter) {

                $isOptional = false;
                if ($oneReflectionParameter->isOptional()) {
                    $isOptional = true;
                }

                $isArray = false;
                if ($oneReflectionParameter->isArray()) {
                    $isArray = true;
                }

                $parameters[] = $parameterAdapter->fromDataToParameter([
                    'name' => $oneReflectionParameter->getName(),
                    'is_optional' => $isOptional,
                    'is_array' => $isArray
                ]);
            }

            return $parameters;
        };

        $code = $codeMethod->getCode();
        $methodName = $codeMethod->getMethodName();
        $className = $code->getClassName();
        $reflectionMethod = new \ReflectionMethod($className, $methodName);

        $language = $code->getLanguage()->get();
        if ($language != 'PHP') {
            throw new CustomMethodException('The input language ('.$language.') is not yet supported.');
        }

        $sourceCodeLines = $getSourceCodeLines($reflectionMethod);
        $parameters = $getParameters($reflectionMethod);

        return new ConcreteClassMethodCustom($name, $sourceCodeLines, $parameters);
    }

}
