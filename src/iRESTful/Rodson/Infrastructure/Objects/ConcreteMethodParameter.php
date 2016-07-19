<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Parameter;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Exceptions\ParameterException;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\ReturnedInterface;

final class ConcreteMethodParameter implements Parameter {
    private $name;
    private $isParent;
    private $isArray;
    private $interface;
    public function __construct($name, $isParent, $isArray, ReturnedInterface $interface = null) {

        if (empty($name) || !is_string($name)) {
            throw new ParameterException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->isParent = (bool) $isParent;
        $this->isArray = (bool) $isArray;
        $this->interface = $interface;

    }

    public function getName() {
        return $this->name;
    }

    public function isParent() {
        return $this->isParent;
    }

    public function isArray() {
        return $this->isArray;
    }

    public function hasReturnedInterface() {
        return !empty($this->interface);
    }

    public function getReturnedInterface() {
        return $this->interface;
    }

}
