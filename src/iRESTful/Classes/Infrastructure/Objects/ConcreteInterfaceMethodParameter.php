<?php
namespace iRESTful\Classes\Infrastructure\Objects;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Parameter;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Types\Type;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Exceptions\ParameterException;

final class ConcreteInterfaceMethodParameter implements Parameter {
    private $name;
    private $type;
    private $isOptional;
    public function __construct($name, Type $type, $isOptional) {

        if (empty($name) || !is_string($name)) {
            throw new ParameterException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->type = $type;
        $this->isOptional = (bool) $isOptional;

    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function isOptional() {
        return $this->isOptional;
    }

}
