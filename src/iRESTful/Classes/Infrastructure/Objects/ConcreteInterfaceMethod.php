<?php
namespace iRESTful\Classes\Infrastructure\Objects;
use iRESTful\Classes\Domain\Interfaces\Methods\Method;
use iRESTful\Classes\Domain\Interfaces\Methods\Exceptions\MethodException;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Parameter;

final class ConcreteInterfaceMethod implements Method {
    private $name;
    private $parameters;
    public function __construct($name, array $parameters = null) {

        if (empty($parameters)) {
            $parameters = null;
        }

        if (empty($name) || !is_string($name)) {
            throw new MethodException('The name must be a non-empty string.');
        }

        if (!empty($parameters)) {
            foreach($parameters as $oneParameter) {
                if (!($oneParameter instanceof Parameter)) {
                    throw new MethodException('The parameters array must only contain Parameter objects.');
                }
            }
        }

        $this->name = $name;
        $this->parameters = $parameters;

    }

    public function getName() {
        return $this->name;
    }

    public function hasParameters() {
        return !empty($this->parameters);
    }

    public function getParameters() {
        return $this->parameters;
    }

}
