<?php
namespace iRESTful\Annotations\Infrastructure\Objects;
use iRESTful\Annotations\Domain\Parameters\Flows\MethodChains\MethodChain;
use iRESTful\Annotations\Domain\Parameters\Flows\MethodChains\Exceptions\MethodChainException;

final class ConcreteAnnotationParameterFlowMethodChain implements MethodChain {
    private $chain;
    private $chainAsString;
    public function __construct(array $chain) {

        if (empty($chain)) {
            throw new MethodChainException('The chain array cannot be empty.');
        }

        foreach($chain as $oneElement) {
            if (empty($oneElement) || !is_string($oneElement)) {
                throw new MethodChainException('The elements inside the chain array must be non-empty strings.');
            }
        }

        $calls = [];
        foreach($chain as $oneElement) {
            $calls[] = $oneElement.'()';
        }

        $this->chain = $chain;
        $this->chainAsString = implode('->', $calls);;
    }

    public function getChain() {
        return $this->chainAsString;
    }

}
