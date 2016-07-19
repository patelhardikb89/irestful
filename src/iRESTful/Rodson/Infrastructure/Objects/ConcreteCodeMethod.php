<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Method;
use iRESTful\Rodson\Domain\Inputs\Codes\Code;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Exceptions\MethodException;

final class ConcreteCodeMethod implements Method {
    private $code;
    private $methodName;
    public function __construct(Code $code, $methodName) {

        if (empty($methodName) || !is_string($methodName)) {
            throw new MethodException('The methodName must be a non-empty string.');
        }

        $className = $code->getClassName();
        if (!method_exists($className, $methodName)) {
            throw new MethodException('The methodName ('.$methodName.') cannot be found on class ('.$className.').');
        }

        $this->code = $code;
        $this->methodName = $methodName;

    }

    public function getCode() {
        return $this->code;
    }

    public function getMethodName() {
        return $this->methodName;
    }

    public function getSourceCode() {
        $removeBraces = function(array $code) {

            $fixIndentation = function(array $lines) {
                $output = [];
                $rightSize = 4;
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

                    if (!is_null($amountToAdd)) {
                        $output[$index] = str_repeat(' ', $amountToAdd).$oneLine;
                    }

                    if (!is_null($amountToSubstract)) {
                        $output[$index] = substr($oneLine, $amountToSubstract);
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
            $filtered = $fixIndentation(array_values(array_filter($lines)));
            return implode(PHP_EOL, $filtered);

        };

        $code = $this->getCode();
        $language = $code->getLanguage();
        if ($language->get() != 'PHP') {
            //throws
        }

        $className = $code->getClassName();
        $methodName = $this->getMethodName();
        $reflectionMethod = new \ReflectionMethod($className, $methodName);

        $fileName = $reflectionMethod->getFileName();
        $startLine = $reflectionMethod->getStartLine();
        $endLine = $reflectionMethod->getEndLine();
        $numLines = $endLine - $startLine;

        $contents = file_get_contents($fileName);
        $contentLines = explode(PHP_EOL, $contents);
        $sliced = array_slice($contentLines, $startLine, $numLines);
        return $removeBraces($sliced);
    }
}
