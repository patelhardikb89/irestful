<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Classes\Methods\Method;
use iRESTful\Rodson\Domain\Outputs\Methods\Method as InterfaceMethod;
use iRESTful\Rodson\Domain\Outputs\Classes\Methods\Exceptions\MethodException;

final class ConcreteClassMethod implements Method {
    private $code;
    private $method;
    public function __construct($code, InterfaceMethod $method) {

        if (empty($code) || !is_string($code)) {
            throw new MethodException('The code must be a non-empty string.');
        }

        $this->code = $code;
        $this->method = $method;

    }

    public function getCode() {
        return $this->code;
    }

    public function getInterfaceMethod() {
        return $this->method;
    }

}
