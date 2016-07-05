<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Parameters\Parameter;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Parameters\Exceptions\ParameterException;

final class ConcreteInterfaceMethodParameter implements Parameter {
    private $name;
    private $interface;
    public function __construct($name, Interface $interface = null) {

        if (empty($name) || !is_string($name)) {
            throw new ParameterException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->interface = $interface;

    }

    public function getName() {
        return $this->name;
    }

    public function hasInterface() {
        return !empty($this->interface);
    }

    public function getInterface() {
        return $this->interface;
    }

}
