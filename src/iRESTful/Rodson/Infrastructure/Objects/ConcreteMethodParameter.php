<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Parameter;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Exceptions\ParameterException;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\ReturnedInterface;

final class ConcreteMethodParameter implements Parameter {
    private $name;
    private $interface;
    public function __construct($name, ReturnedInterface $interface = null) {

        if (empty($name) || !is_string($name)) {
            throw new ParameterException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->interface = $interface;

    }

    public function getName() {
        return $this->name;
    }

    public function hasReturnedInterface() {
        return !empty($this->interface);
    }

    public function getReturnedInterface() {
        return $this->interface;
    }

}
