<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Flows\Flow;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Flows\MethodChains\MethodChain;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Flows\Exceptions\FlowException;

final class ConcreteAnnotationParameterFlow implements Flow {
    private $propertyName;
    private $methodChain;
    private $keyname;
    public function __construct($propertyName, MethodChain $methodChain, $keyname) {

        if (empty($propertyName) || !is_string($propertyName)) {
            throw new FlowException('The propertyName must be a non-empty string.');
        }

        if (empty($keyname) || !is_string($keyname)) {
            throw new FlowException('The keyname must be a non-empty string.');
        }

        $this->propertyName = $propertyName;
        $this->methodChain = $methodChain;
        $this->keyname = $keyname;

    }

    public function getPropertyName() {
        return $this->propertyName;
    }

    public function getMethodChain() {
        return $this->methodChain;
    }

    public function getKeyname() {
        return $this->keyname;
    }

    public function getData() {
        return [
            'property_name' => $this->getPropertyName(),
            'keyname' => $this->getKeyname(),
            'method_chain' => $this->getMethodChain()->getChain()
        ];
    }

}
