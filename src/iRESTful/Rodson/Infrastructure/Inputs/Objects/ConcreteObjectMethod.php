<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Objects\Methods\Method;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Method as CodeMethod;
use iRESTful\Rodson\Domain\Inputs\Objects\Methods\Exceptions\MethodException;

final class ConcreteObjectMethod implements Method {
    private $name;
    private $codeMethod;
    public function __construct($name, CodeMethod $codeMethod) {

        if (empty($name) || !is_string($name)) {
            throw new MethodException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->codeMethod = $codeMethod;
    }

    public function getName() {
        return $this->name;
    }

    public function getMethod() {
        return $this->codeMethod;
    }

}
