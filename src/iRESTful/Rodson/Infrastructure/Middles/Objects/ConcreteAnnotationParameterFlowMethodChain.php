<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Flows\MethodChains\MethodChain;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Flows\MethodChains\Exceptions\MethodChainException;

final class ConcreteAnnotationParameterFlowMethodChain implements MethodChain {
    private $chain;
    public function __construct(array $chain) {

        if (empty($chain)) {
            throw new MethodChainException('The chain array cannot be empty.');
        }

        foreach($chain as $oneElement) {
            if (empty($oneElement) || !is_string($oneElement)) {
                throw new MethodChainException('The elements inside the chain array must be non-empty strings.');
            }
        }

        $this->chain = $chain;

    }

    public function getChain() {

        $calls = [];
        foreach($this->chain as $oneElement) {
            $calls[] = $oneElement.'()';
        }

        return implode('->', $calls);
    }

    public function getData() {
        return $this->chain;
    }

}
