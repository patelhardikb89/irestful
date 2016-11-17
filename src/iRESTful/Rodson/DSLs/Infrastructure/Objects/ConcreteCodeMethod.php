<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Methods\Method;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Code;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Methods\Exceptions\MethodException;

final class ConcreteCodeMethod implements Method {
    private $code;
    private $methodName;
    public function __construct(Code $code, string $methodName) {

        $className = $code->getClassName();
        if (!method_exists($className, $methodName)) {
            throw new MethodException('The methodName ('.$methodName.') cannot be found on class ('.$className.').');
        }

        $this->code = $code;
        $this->methodName = $methodName;

    }

    public function getCode(): Code {
        return $this->code;
    }

    public function getMethodName(): string {
        return $this->methodName;
    }
}
