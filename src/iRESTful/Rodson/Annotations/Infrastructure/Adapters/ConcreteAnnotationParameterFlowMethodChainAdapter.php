<?php
namespace iRESTful\Rodson\Annotations\Infrastructure\Adapters;
use iRESTful\Rodson\Annotations\Domain\Parameters\Flows\MethodChains\Adapters\MethodChainAdapter;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Parameter as ConstructorParameter;
use iRESTful\Rodson\Annotations\Infrastructure\Objects\ConcreteAnnotationParameterFlowMethodChain;

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
