<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Method;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Parameters\Parameter;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;

final class ConcreteInterfaceMethod implements Method {
    private $name;
    private $returnedType;
    private $parameters;
    public function __construct($name, PropertyType $returnedType = null, array $parameters = null) {

        if (empty($parameters)) {
            $parameters = null;
        }

        if (empty($name) || !is_string($name)) {
            throw new MethodException('The name must be a non-empty string.');
        }

        foreach($parameters as $oneParameter) {

            if (!($oneParameter instanceof Parameter)) {
                throw new MethodException('The parameters array must only contain Parameter objects.');
            }

        }

        $this->name = $name;
        $this->returnedType = $returnedType;
        $this->parameters = $parameters;

    }

    public function getName() {
        return $this->name;
    }

    public function hasReturnedType() {
        return !empty($this->returnedType);
    }

    public function getReturnedType() {
        return $this->returnedType;
    }

    public function hasParameters() {
        return !empty($this->parameters);
    }

    public function getParameters() {
        return $this->parameters;
    }

}
