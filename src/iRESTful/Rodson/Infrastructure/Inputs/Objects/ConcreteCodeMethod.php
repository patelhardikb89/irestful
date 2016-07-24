<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
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
}
