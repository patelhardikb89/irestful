<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Parameter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Exceptions\ParameterException;

final class ConcreteClassInterfaceMethodParameter implements Parameter {
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
