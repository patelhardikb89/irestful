<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Flows\MethodChains\Adapters\MethodChainAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Parameter as ConstructorParameter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteAnnotationParameterFlowMethodChain;

final class ConcreteAnnotationParameterFlowMethodChainAdapter implements MethodChainAdapter {

    public function __construct() {

    }

    public function fromConstructorParameterToMethodChain(ConstructorParameter $constructorParameter) {

        $method = $constructorParameter->getMethod();

        $chain = [
            $method->getName()
        ];

        if ($method->hasSubMethod()) {
            $subMethod = $method->getSubMethod();
            $chain[] = $subMethod->getName();
        }

        return new ConcreteAnnotationParameterFlowMethodChain($chain);
    }

}
